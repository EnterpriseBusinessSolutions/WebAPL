<section>
    <div class="dirs_menu">
        <div class="wrap">
            <a href="javascript:;">Principala »</a>
            <a href="javascript:;">Contacte</a>
        </div>
    </div>
    <div class='wrap'>
        <p class="c_title">contacte</p>
        <div class='left ccc'>
            <div class='contact_l'>
                <p class='subt'>Legatură directă</p>
                <ul class='date_contact'>
                    <li>
                        <p>Telefon Anticameră</p>
                        <p>(0-237) 22-33-44</p>
                    </li>
                    <li>
                        <p>Email</p>
                        <p>info@straseni.gov.md</p>
                    </li>
                    <li>
                        <p>Relatii cu publicul </p>
                        <p>(0-237) 22-33-44</p>                                    
                    </li>
                    <li>
                        <p>Fax</p>
                        <p>(0-237) 55-66-77</p>
                    </li>
                </ul>
                <div class="prp">
                    <img src="<?= res('assets/img/phone_book.png'); ?>">
                    <a href="urgenta.php">Toate numerele de telefon</a>
                </div>

            </div>
            <div class="chat"> 
                <form action="" method="">
                    <img src="<?= res('assets/img/chat_man.png'); ?>" class="mn">
                    <span class="chat_dot"></span>
                    <span class="green">Chat-</span><span class="violet">online</span>
                    <hr>
                    <p class="center">Vorbeste direct cu un reprezentant al primariei</p>
                    <div class="cont">
                        <label>Functionar *</label>
                        <select>
                            <option>ghjghjghj</option>
                            <option>ghjghjghjgh</option>
                            <option>ghjghjghjgh</option>
                            <option>ghjghjgh</option>
                        </select>
                        <label>Numele Prenumele * </label>
                        <input type="text" >
                        <label>Email*</label>
                        <input type="text" >    
                        <label>Cod de verificare*</label>
                        <input class="code" type="text">
                        <img src="<?= res('assets/img/code.png'); ?>">
                        <input type="submit" value="trimite"/>
                    </div>
                </form>
            </div>
        </div>
        <div class='left contact_r'>
            <p class='subt'>Adresa</p>
            <div id="map-canvas2" style="width:450px; height:450px;"></div>
            <div class="prp">
                <img src="<?= res('assets/img/notebook.png'); ?>">
                <a href="javascript:;">Orarul rutelor de autobus</a>
            </div>
            <div class="map_info"><?= $page->text; ?></div>
        </div>
        <div class='left form contact'>
            <?= View::make('sections.pages.blocks.contactForm'); ?>
        </div>
        <div class='clearfix140'></div>
        <?php if ($page->have_socials) { ?>
            <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
        <?php } ?>
        <div class='hr_grey'></div>
    </div>
</section>