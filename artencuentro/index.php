
<?php
include_once 'presentation.class.php';
View::start('Artencuentro');

View::topnav();

echo '
        <div>
            <p id="parrafo1">Nos dedicamos a la intermediación entre profesionales de las artes gráficas y empresas. Suministramos un lugar en internet donde los profesionales de las artes gráficas pueden presentar trabajos previos
            para mostrar sus habilidades.</p>
        </div>
    
        <div class="imagen">
            <img id="imagen" src="imagenes/i-was-a-botox-junkie-es.jpg" alt="botox junkie graffiti">
        </div>
    
        <h1><b>Ventajas:</b></h1>
    
        <div class="parrafo2">
            <p>Los profesionales se veran beneficiados por tener una plataforma única donde las empresas podran ver su trabajo y ofertarles puestos si estos les gustan.
            Las empresas tendrán la ventaja de poder ver el trabajo antes de contratar a una persona y además podran poner ofertas de trabajo para que los usuarios de la página las vean.
            Los visitantes podran ver los trabajos de los profesionales y marcarlos en caso de que les guste algun trabajo en especial.</p>
    
        </div>
    
        <div class="footer">
            <h6><b>Artencuentro Ⓒ</b></h6>
        </div>
        ';

View::end();