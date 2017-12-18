<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Preguntas</title>
        <link rel='stylesheet' type='text/css' href='estilos/style2.css' />
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
    </head>
    <body>
        <div id='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="s1">

                <div>
                <?php
                    echo "<h2>Tabla con PHP</h2>";
                    $xml = simplexml_load_file('XML/preguntas.xml');

                    echo '<table border=1> <tr> <th> PREGUNTA </th>
                                                <th> TEMA </th>
                                                <th> COMPLEJIDAD </th>';

                    foreach($xml->assessmentItem as $pregunta){
                        $preg = $pregunta->itemBody->p;
                        $tema = $pregunta['subject'];
                        $complejidad = $pregunta['complexity'];
                        echo ("<tr><td>$preg</td>
                                   <td>$tema</td>
                                   <td>$complejidad</td></tr>");
                    }
                    echo '</table>';

                    echo "<h2>Tabla con XSL</h2>";
                    // Carga el fichero XML origen
                    $xml = new DOMDocument;
                    $xml->load('XML/preguntas.xml');

                    $xsl = new DOMDocument;
                    $xsl->load('XML/verPreguntas.xsl');

                    // Configura el procesador
                    $proc = new XSLTProcessor();
                    $proc->importStyleSheet($xsl); // adjunta las reglas XSL

                    echo $proc->transformToXML($xml);
                ?>
                </div>
            </section>
            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>
        </div>
        <script>
            $(document).ready(function () {
                    $("#logOut").click(function () {
                        alert("¡Gracias por tu visita!");
                        window.location.href = "decrementarContador.php";
                    });
            });
        </script>
    </body>
</html>
