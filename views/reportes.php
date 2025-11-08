<?php include "scripts.php" ?>
<title>Reportería</title>
</head>


<body>

    <?php include "menu.php" ?>

    <main>

        <center>
            <form class="frm_crear_u" method="POST" action="../assets/reports/pdf/generar_miembros.php" target="_blank">
                <div class="header_form">
                    <h1 align="center"><i class="las la-file"></i> <br> Generar reportes</h1>
                    <br>
                    <hr width="750px"> <br>
                </div>

                <div class="body_form">

                    <div class="left_column">

                        <div class="input-group">
                            <input type="date" id="fecha-ini" name="fecha-inicio" class="input-date" require />
                            <label for="fecha-desde" class="floating-label">Desde:</label>
                        </div>

                        <br>

                        <div class="input-group">
                            <input type="date" id="fecha-fini" name="fecha-fin" class="input-date" require />
                            <label for="fecha-hasta" class="floating-label">Hasta:</label>
                        </div>

                        <br>
                        <div class="input-group">
                            
                        <select class="form-control" name="tipo_reporte" required>
                            <option value="miembros">Reporte de Miembros</option>
                        </select>
                        </div>

                    </div>
<br>
                    
                </div>
                <div class="butonnn">
                        <br>
                        <button type="submit" name="generar_reporte">Generar reporte</button>

                    </div>
            </form>

        </center>
    </main>

    <?php include "footer.php" ?>