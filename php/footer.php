<?php
  global $page;

  if(!isset($page) && isset($_GET['page'])) $page = $_GET['page'];

  $footer = '<footer class="footer">
              <div class="container">
                <div class="content is-smaller has-text-centered">
                  <span><a href="/">Home</a></span> 
                  <span>&copy; 2020 - '.date('Y').' ..::ch::..</span> 
                  <span><a href="/anb"'.(($page == 'anb')?' class="active"':'').'>ANB</a></span>
                  ·
                  <span><a href="/privacypolicy"'.(($page == 'privacypolicy')?' class="active"':'').'>Datenschutzerklärung</a></span>
                  ·
                  <span><a href="/imprint"'.(($page == 'imprint')?' class="active"':'').'>Impressum</a></span>
                </div>
              </div>
            </footer>';
?>
