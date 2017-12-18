<header class='main' id='h1'>
    <div class='left'>
    </div>

    <div class='center'>
        <h2>Quiz: el juego de las preguntas</h2>
        <?php
            if (isset($_SESSION['alumno'])){
            ?>
                <span id='logOut'><a href='#'>Logout</a></span>
            <?php
            }elseif(!isset($_POST['uname'])){
            ?>
                <span><a id='reg'href='Registrar.php'>Registrarse</a></span>
                <?php
                if(isset($_SESSION['intentos'])){
                    if($_SESSION['intentos'] < 3){
                        ?><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button><?php
                    }
                }else{
                    ?><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button><?php
                }
                ?>
            <?php
            }
        ?>

        <div id="id01" class="modal">
            <form class="modal-content animate" id="login" name="login" action="Login.php" method="post">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <div class="container">
                    <label><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="uname" required>

                    <label><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" required>

                    <button type="submit">Login</button><br><br>
                    <input type="checkbox" name="logCheckbox" value="si">Juro solemnemente que mis intenciones no son buenas<br><br>

                    <a id='reg'href='recuperarContra.php'>Se me ha olvidado la contraseña :(</a>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class='right'>
        <?php
        if(isset($_SESSION['alumno'])){

            include 'connect.php';

            if (!$link) {
                die('Could not connect to MySQL: ' . mysql_error());
            }

            $email = $_SESSION['email'];
            $usuarios = mysqli_query($link,"select * from usuarios where email='$email'");
            $cont = mysqli_num_rows($usuarios);

            if($cont==1) {
                $row = mysqli_fetch_array($usuarios);
                if($row['foto']===NULL || $row['foto']==""){
                   echo '<p align="right">' . $row['email'] . '</p>';
                }
                else {
                   echo "<img src='data:image/jpeg;base64," . base64_encode( $row['foto'] ) . "' alt='Imagen de Usuario' height='100px' align='right'/>";
                }
            }

            $usuarios->close();
            mysqli_close($link);
        }
        ?>
    </div>
</header>
<nav class='main' id='n1' role='navigation'>
    <ul>
    <?php
        //Usuario logueado
        if(isset($_SESSION['alumno'])){

            $alumno = $_SESSION['alumno'];
            //Es un alumno
            if($alumno == 1){
                echo "<li><a id='home' href='layout.php'>Inicio</a></li>
                      <li><a id='preg' href='gestionPreguntas.php'>Gestionar Preguntas</a></li>
                      <li><a id='buscar' href='buscarPregunta.php'>Buscar Preguntas</a></li>
                      <li><a id='Cred' href='creditos.php'>Créditos</a></li>";
            }//Es un profesor
            else{
                echo "<li><a id='home' href='layout.php'>Inicio</a></li>
                      <li><a id='rev' href='revisarPreguntas.php'>Revisar Preguntas</a></li>
                      <li><a id='Cred' href='creditos.php'>Créditos</a></li>";
            }
        }else{
            echo "<li><a id='home' href='layout.php'>Inicio</a></li>
                  <li><a id='jugar' href='jugar.php'>Jugar</a></li>
                  <li><a id='Cred' href='creditos.php'>Créditos</a></li>";
        }
    ?>
    </ul>
</nav>
<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
