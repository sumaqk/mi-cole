# Sistema de Licencias — Errores y Aprendizajes

## El problema original

El sistema tiene dos frontends:
- **Nuevo**: React SPA en `/mi-cole/public/` (index.html)
- **Antiguo**: Laravel Blade en `/mi-cole/public/index/home`

La idea: si la licencia está activa → mostrar el React. Si vence → mostrar el Blade.

---

## Error 1: El bucle negro

**Síntoma**: Al vencer la licencia, la página se ponía negra en bucle infinito. No se podía abrir F12.

**Causa**: La cadena de redirecciones era circular:

```
React detecta licencia vencida
    → redirige a index/home (VITE_FALLBACK_URL)
    → index/home redirigía a / (por alguna config)
    → / carga el React
    → React detecta licencia vencida
    → bucle infinito
```

**Solución**: El fallback nunca debe apuntar a una URL que pueda volver a cargar el React.
Usar `index/blade` como fallback — es un callejón sin salida que solo muestra el Blade.

---

## Error 2: `if (!res.ok) return true`

**Código problemático**:
```javascript
if (!res.ok) return true // si el servidor da error HTTP → permite acceso
```

**Por qué se puso**: Para evitar el bucle negro. Si el servidor de licencias fallaba,
devolver `true` evitaba que el React redirigiera y causara el bucle.

**El problema real**: Con el bucle resuelto (fallback a `index/blade`), esta línea
deja pasar a cualquiera si el panel responde con un error HTTP, aunque la licencia esté vencida.

**Corrección**:
```javascript
if (!res.ok) return false // error HTTP del panel = licencia inválida
// el catch sigue en return true = si el servidor está caído, no bloqueamos
```

---

## Error 3: El check de `file_exists` en IndexController

**Código problemático**:
```php
public function actionIndex() {
    if (file_exists(public_path('index.html'))) {
        return redirect('/');
    }
    // si no existe, muestra Blade
    return view('home.index', compact('modal'));
}
```

**Por qué parecía necesario**: Si `index/home` siempre redirigía a `/`, y `/` no encontraba
`index.html`, redirigía de vuelta a `home.index` → bucle.

**El problema**: La raíz del bucle estaba en la ruta `/`, no en `actionIndex`.

**Solución inteligente**: Arreglar la causa raíz — la ruta `/` muestra el Blade directamente
en vez de redirigir a `home.index`:

```php
// web.php
Route::get('/', function () {
    $path = public_path('index.html');
    if (!file_exists($path)) {
        return view('home.index', compact('modal')); // Blade directo, sin redirect
    }
    return response(file_get_contents($path), 200)->header('Content-Type', 'text/html');
});

// IndexController.php
public function actionIndex() {
    return redirect('/'); // simple, sin checks
}
```

---

## Flujo final correcto

```
Usuario entra a index/home
    → redirect('/')
    → ¿existe index.html?
        NO  → muestra Blade directo (sin redirect, sin bucle)
        SI  → carga React
                → chequea licencia en panel.codehector.com
                    ACTIVA  → muestra React
                    VENCIDA → window.location = index/blade → Blade (fin)
```

---

## Regla de oro

**Nunca** usar como fallback de licencia vencida una URL que pueda volver a cargar el React.
El fallback debe ser siempre un endpoint que muestre HTML estático sin lógica de redirección.
