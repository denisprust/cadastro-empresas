

        <script src="<?=NODE_MODULES.'/@fortawesome/fontawesome-free/js/all.min.js'?>"></script>
        <script src="<?=NODE_MODULES.'/jquery/dist/jquery.min.js'?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="<?=NODE_MODULES.'/bootstrap/dist/js/bootstrap.min.js'?>"></script>
        <script src="<?=NODE_MODULES.'/jquery-mask-plugin/dist/jquery.mask.min.js'?>"></script>
        <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="<?=ASSETS.'/common.js'?>"></script>
        <?php 
            if (!empty($aJs)) {
                foreach ($aJs as $js) {
                    $link = ASSETS.'/'.$js;
                    echo "<script src='{$link}'></script>";
                }
            }
        ?>
    </body>
</html>