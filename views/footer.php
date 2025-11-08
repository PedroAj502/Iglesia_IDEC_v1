</div>
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha384-q8i/"> </script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_ini').DataTable();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#data_table').DataTable();
    });
</script>
 
<script type="text/javascript">
    function confirm_eraser_ce() {
        var resp = confirm("¿Desea eliminar esta célula?");
        if (resp == true) {
            return true;
        } else {
            return false;
        }
    }
</script>


<script type="text/javascript">
    function confirm_eraser_u() {
        var resp = confirm("¿Desea eliminar el usuario?");
        if (resp == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
    function confirm_eraser_min() {
        var resp = confirm("¿Desea eliminar el ministerio?");
        if (resp == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
    function confirm_eraser_miem() {
        var resp = confirm("¿Desea eliminar al miembro?");
        if (resp == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<!-- nuevos scripsts -->
<script src="../assets/js/js_main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>

</html>