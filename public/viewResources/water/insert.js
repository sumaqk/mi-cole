'use strict';

$('#frmInsertWater').formValidation(objectValidate(
{
	txtResult:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message : '<b style="color: red;">Formato incorrecto. [Ejemplo: 0.1, 0.5, 1.0].</b>',
				regexp : /^[0-1]\.[0-9]$/
			}
		}
	}
}));

var areaChartData=
{
	labels  : labelsGraphic.split(','),
	datasets: [
		{
			label               : 'Electronics',
			fillColor           : '#00BFEF77',
			strokeColor         : '#004CEF77',
			pointColor          : 'rgba(210, 214, 222, 1)',
			pointStrokeColor    : '#02378BFF',
			pointHighlightFill  : '#fff',
			pointHighlightStroke: 'rgba(220,220,220,1)',
			data                : dataGraphic.split(',')
		}
	]
};

$(function()
{
	var barChartCanvas=$('#barChart').get(0).getContext('2d');
	var barChart=new Chart(barChartCanvas);
	var barChartData=areaChartData;

	var barChartOptions=
	{
		//Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
		scaleBeginAtZero        : true,
		//Boolean - Whether grid lines are shown across the chart
		scaleShowGridLines      : true,
		//String - Colour of the grid lines
		scaleGridLineColor      : 'rgba(0,0,0,.05)',
		//Number - Width of the grid lines
		scaleGridLineWidth      : 1,
		//Boolean - Whether to show horizontal lines (except X axis)
		scaleShowHorizontalLines: true,
		//Boolean - Whether to show vertical lines (except Y axis)
		scaleShowVerticalLines  : true,
		//Boolean - If there is a stroke on each bar
		barShowStroke           : true,
		//Number - Pixel width of the bar stroke
		barStrokeWidth          : 2,
		//Number - Spacing between each of the X value sets
		barValueSpacing         : 5,
		//Number - Spacing between data sets within X values
		barDatasetSpacing       : 1,
		//String - A legend template
		legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
		//Boolean - whether to make the chart responsive
		responsive              : true,
		maintainAspectRatio     : true
	}

	barChartOptions.datasetFill = false;
	barChart.Bar(barChartData, barChartOptions);
});

let selectedImages = [];

function handleImageSelection(input) {
	selectedImages = [];
    const files = Array.from(input.files);
    const maxFiles = 3;

    if (selectedImages.length + files.length > maxFiles) {
        alert(`Solo puedes tener un máximo de ${maxFiles} imágenes.`);
        return;
    }

    for (const file of files) {
        if (!file.type.startsWith('image/')) {
            alert("Solo se permiten archivos de tipo imagen.");
            return;
        }
        selectedImages.push(file);
    }

    renderImages();
}

function renderImages() {	
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = '';

    selectedImages.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageContainer = document.createElement('div');
            imageContainer.className = 'image-container';

            imageContainer.innerHTML = `
                <img src="${e.target.result}" alt="Imagen ${index + 1}">                
            `;

            imagePreview.appendChild(imageContainer);
        };
        reader.readAsDataURL(file);
    });
	
}

function removeImage(index) {
    selectedImages = [];
    renderImages();
}

function sendFrmInsertWater() {
    let isValid = null;

    $('#frmInsertWater').data('formValidation').resetForm();
    $('#frmInsertWater').data('formValidation').validate();

    isValid = $('#frmInsertWater').data('formValidation').isValid();

    if (!isValid) {
        incorrectNote();
        return;
    }

    // Confirmar antes de enviar
    confirmDialogSend('frmInsertWater', () => {
        // Crear FormData e incluir imágenes seleccionadas
        const formData = new FormData(document.getElementById('frmInsertWater'));		

		// Agregar imágenes al FormData
        selectedImages.forEach((image, index) => {
			console.log(`Agregando imagen ${index}:`, image);  // Verifica el archivo
			formData.append(`images[${index}]`, image);
		});

        // Enviar el formulario con fetch
        fetch('water/insert', {
            method: 'post',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                alert("Datos registrados correctamente.");
                // Limpiar selección de imágenes
                selectedImages = [];
                renderImages();
            })
            .catch(error => {
                console.error("Error al enviar datos:", error);
                alert("Hubo un error al registrar los datos.");
            });
    });
}
