<?php echo $header; ?>
<div class="module module--initnavbar"  data-navbar="navbar-dark"><!-- module -->
  <div class="container">
  <?php echo $content_top; ?>
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <?php if (!empty($success)) { ?>
          <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?></div>
        <?php } ?>
      </div><!-- /.col-sm-10 -->
     
      <!-- Content column start -->
      <div class="col-sm-8">
        <!-- Post start -->
        <div class="post">
          
          <div class="post-header font-alt">
            <h1 class="post-title"><?php echo $contest_title; ?></h1>
          </div>
          <?php if($image){ ?>
            <div class="post-thumbnail">
              <img src="<?php echo $image; ?>" alt="<?php echo $contest_title; ?>">
            </div>
          <?php } ?>
         

          <div class="post-entry ">
          <?php if(!empty($contest_propose)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_propose; ?></h4>
            <?php echo $contest_propose; ?>
          <?php } ?>
          
          <?php if ($contest_status == 2) { ?>
            <h4 class="font-alt mb-10">Победители</h4>
            <table class="table table-striped table-border checkout-table">
              
              <?php if($contest_id == 7) {?>
              <thead>
              <th class="hidden"></th>
                <th>Название проекта</th>
                <th>Автор проекта</th>
                <th>Адаптор проекта</th>
                <th>Вид сотрудничества</th>
              </thead>
              <tbody>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/playhead/projects/livequestisrael.html" target="_blank">"Живые квесты"</a></td>
                <td><a href="iniciativies/playhead/" target="_blank">Игра головой, Санкт Петербург</a></td>
                <td><a href="iniciativies/20141106025738.html" target="_blank">Теплые встречи, Киев</a></td>
                <td>Консультации</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/20151019212706/projects/20151030013942.html" target="_blank">Московский / Екатеринбургский Еврейский Кинофестиваль </a></td>
                <td>Ark Pictures, Москва</td>
                <td><a href="iniciativies/gilel-ekaterinburg/" target="_blank">Гилель, Екатеринбург</a></td>
                <td>Партнерство</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/netzerrussia/projects/20141111165431.html" target="_blank">Творческий процесс</a></td>
                <td><a href="iniciativies/netzerrussia.html" target="_blank">Молодежный клуб Нецер, Москва</a></td>
                <td><a href="iniciativies/gilel-spb/" target="_blank">Гилель, Санкт Петербург</a></td>
                <td>Консультации</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/netzerrussia/projects/20140519221638.html" target="_blank">Школа еврейского лидерства</a></td>
                <td><a href="iniciativies/netzerrussia.html" target="_blank">Молодежный клуб Нецер, Москва</a></td>
                <td><a href="iniciativies/20140806140916.html" target="_blank">Хава Нагила, Челябинск</a></td>
                <td>Франчайзинг</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/playhead/projects/livequestisrael.html" target="_blank">"Живые квесты"</a></td>
                <td><a href="iniciativies/playhead/" target="_blank">Игра головой, Санкт Петербург</a></td>
                <td>Шиурей Тора Любавич г.Киев</td>
                <td>Консультации</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/netzerrussia/projects/20141111165431.html" target="_blank">Творческий процесс </a></td>
                <td><a href="iniciativies/netzerrussia.html" target="_blank">Молодежный клуб Нецер, Москва</a></td>
                <td><a href="iniciativies/20140702151938.html" target="_blank">Шиурей Тора Любавич Днепропетровск</a></td>
                <td>Франчайзинг</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/20130716092458/projects/20140430221435.html" target="_blank">Таки Да</a></td>
                <td><a href="iniciativies/20130716092458.html" target="_blank">ОА Vulturas г. Кишинев</a></td>
                <td>Еврейская община г. Жмеренка</td>
                <td>Консультации</td>
                </tr>
                </tbody>
              <?php } ?>

               <?php if($contest_id == 8) {?>
                 
                    <thead>
                    <tr><th class="hidden"></th><th>Название проекта</th><th>Автор</th><th>Адаптор</th></tr>
                    </thead>
                    <tbody>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/meod/projects/coffeeandbrain.html" target="_blank">COFFEE&amp;BRAIN</a></td>
                    <td><a href="iniciativies/meod/" target="_blank">МЕОД (Молодежное Еврейское Образование Днепропетровска)</a></td>
                    <td><a href="iniciativies/20140519125014.html" target="_blank">Гилель, Хабаровск</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/playhead/projects/livequestisrael.html" target="_blank">Живые Квесты</a></td>
                    <td><a href="iniciativies/playhead/" target="_blank">Игра головой, Санкт Петербург</a></td>
                    <td><a href="iniciativies/20140513193948.html" target="_blank">Подарок Киев</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/playhead/projects/livequestisrael.html" target="_blank">Живые Квесты</a></td>
                    <td><a href="iniciativies/playhead/" target="_blank">Игра головой, Санкт Петербург</a></td>
                    <td><a href="iniciativies/20140623193339.html" target="_blank">ЕСКЦ «Гилель» г. Симферополь</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/20140509233139/projects/memoryart.html" target="_blank">Memory|Art</a></td>
                    <td><a href="iniciativies/20140509233139.html" target="_blank">Сохнут Киев</a></td>
                    <td><a href="iniciativies/gilel-moskva/" target="_blank">Гилель, Москва</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/jewfish/projects/20140605114933.html" target="_blank">Проект «TextNext»</a></td>
                    <td><a href="iniciativies/jewfish/" target="_blank">JewF.I.S.H. Project, Москва</a></td>
                    <td><a href="iniciativies/migrash-baltia/" target="_blank">Культурно-Образовательное Сообщество «Миграш-Балтия», Рига</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/jewfish/projects/20140605114933.html" target="_blank">Проект «TextNext»</a></td>
                    <td><a href="iniciativies/jewfish/" target="_blank">JewF.I.S.H. Project, Москва</a></td>
                    <td><a href="iniciativies/migrash-samara/" target="_blank">Migrash.Community of practice Самара</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/jewfish/projects/20140605114933.html" target="_blank">Проект «TextNext»</a></td>
                    <td><a href="iniciativies/jewfish/" target="_blank">JewF.I.S.H. Project, Москва</a></td>
                    <td><a href="iniciativies/gilel-spb/" target="_blank">Гилель, Петербург</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/migrash-samara/projects/20140713123744.html" target="_blank">CВОБОДА ОБРАЗОВАНИЯ</a></td>
                    <td><a href="iniciativies/migrash-samara/" target="_blank">Migrash.Community of practice Самара</a></td>
                    <td><a href="iniciativies/amuta/" target="_blank">ОО Амута, Харьков</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/amuta/projects/semsorok.html" target="_blank">Семь Сорок</a></td>
                    <td><a href="iniciativies/amuta/" target="_blank">ОО «Амута», Харьков</a></td>
                    <td><a href="iniciativies/20140702151938.html" target="_blank">Шиурей Тора Любавич, Днепропетровск</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/20130716092458/projects/20140430221435.html" target="_blank">Таки ДА</a></td>
                    <td><a href="iniciativies/20130716092458.html" target="_blank">AO «Vulturas», Кишинев</a></td>
                    <td><a href="iniciativies/20140620184104.html" target="_blank">ОО «Тульский областной еврейский благотворительный Центр «Хасдэй Нэшама»\»Милосердие», Тула</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/20130716092458/projects/20140430221435.html" target="_blank">Таки ДА</a></td>
                    <td><a href="iniciativies/20130716092458.html" target="_blank">AO «Vulturas», Кишинев</a></td>
                    <td><a href="iniciativies/volgo.html" target="_blank">ВГОБО «Еврейский общинный центр», Волгоград</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/shabbat-xost/projects/shabbat-host.html" target="_blank">Шабат Хост</a></td>
                    <td><a href="iniciativies/midrasha-czionit-kiev/" target="_blank">Мидраша Ционит, Киев</a></td>
                    <td><a href="iniciativies/meod/" target="_blank">МЕОД (Молодежное Еврейское Образование Днепропетровска)</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="iniciativies/netzerrussia/projects/20140519221638.html" target="_blank">«Школа еврейского лидерства»</a></td>
                    <td><a href="iniciativies/netzerrussia.html" target="_blank">НЕЦЕР России, Москва</a></td>
                    <td><a href="iniciativies/jewishkaliningrad.html" target="_blank">Еврейская община Калининграда</a></td>
                    </tr>
                    </tbody>
               <?php } ?>

               <?php if($contest_id == 6) {?>
               <thead>
                <tr><th class="hidden"></th><th>Название проекта</th><th>Автор</th><th>Адаптор</th></tr>
                </thead>
                <tbody>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/20140513193948/projects/20140520233924.html" target="_blank">ПОДАРОК</a></td>
                <td><a href="iniciativies/20140513193948.html" target="_blank">Подарок, Киев</a></td>
                <td><a href="iniciativies/20141106025738.html" target="_blank">Теплые встречи, Киев</a></td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/gilel-moskva/proektyi/20141105162904.html" target="_blank">JEWISH PROFESSIONAL NETWORKING</a></td>
                <td><a href="iniciativies/gilel-moskva/" target="_blank">Гилель Москва</a></td>
                <td><a href="iniciativies/20141118205510.html" target="_blank">Platinum Одесса</a></td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/netzerrussia/projects/20141111165431.html" target="_blank">Творческий процесс</a></td>
                <td><a href="iniciativies/netzerrussia.html" target="_blank">Молодежный клуб Нецер Москва</a></td>
                <td><a href="iniciativies/20141125231956.html" target="_blank">Творческая мастерская диалога еврейскрй и европейской культур: Талмуд – Театр – Текст (ТТТ), Москва</a></td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/playhead/projects/livequestisrael.html" target="_blank">Образовательные ролевые игры «Живые квесты»</a></td>
                <td><a href="iniciativies/playhead/" target="_blank">Игра головой, Санкт Петербург</a></td>
                <td><a href="iniciativies/netzerrussia.html" target="_blank">Молодежный клуб Нецер Москва</a></td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/20140703180913/projects/20140704125008.html" target="_blank">Неформальная театральная студия</a></td>
                <td><a href="iniciativies/20140703180913.html" target="_blank">Неформальная театральная студия "Точка Сборки», Киев</a></td>
                <td><a href="iniciativies/20130716092458.html" target="_blank">AO "Vulturas", Кишинев</a></td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="iniciativies/20130716092458/projects/20140430101329.html" target="_blank">Интеллектуальное казино</a></td>
                <td><a href="iniciativies/20130716092458.html" target="_blank">AO "Vulturas", Кишинев</a></td>
                <td><a href="iniciativies/20141117131356.html" target="_blank">Менора, Екатеринбург</a></td>
                </tr>
                </tbody>
                  <?php } ?>
            </table>
          
          <?php } ?>


          <?php if (!$is_expert && $contest_status == 1) { ?>
            <div class="row">
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                  <a href="<?php echo $im_deal; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20"><?php echo $text_im_deal; ?></a>
                </div>
              </div>  
            </div>
          <?php } ?>

          
          <?php if(!empty($contest_description)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_description; ?></h4>
            <?php echo $contest_description; ?>
          <?php } ?>
            <h4 class="font-alt mb-10"><?php echo $entry_contest_dates; ?></h4>
            <table class="table table-striped table-border checkout-table">
                <tbody>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_start; ?> :</th>
                    <td><?php echo $contest_date_start; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_datetime_end; ?> :</th>
                    <td><?php echo $contest_datetime_end; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_rate; ?> :</th>
                    <td><?php echo $contest_date_rate; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_result; ?> :</th>
                    <td><?php echo $contest_date_result; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_finalist; ?> :</th>
                    <td><?php echo $contest_date_finalist; ?></td>
                  </tr>

                </tbody>
              </table>
            

          
          <?php if(!empty($contest_location)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_location; ?></h4>
            <?php echo $contest_location; ?>
          <?php } ?>
          <?php if(!empty($contest_organizer)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_organizer; ?></h4>
            <?php echo $contest_organizer; ?>
          <?php } ?>
          <?php if(!empty($contest_members)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_members; ?></h4>
            <?php echo $contest_members; ?>
          <?php } ?>
          <?php if(!empty($contest_contacts)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_contacts; ?></h4>
            <?php echo $contest_contacts; ?>
          <?php } ?>
          <?php if(!empty($contest_timeline_text)) { ?>
            <h4 class="font-alt mb-0"><?php echo $entry_contest_timeline_text; ?></h4>
            <?php echo $contest_timeline_text; ?>
          <?php } ?>

          <?php if(!empty($contest_downloads)) { ?>
            <h4 class="font-alt mb-10"><?php echo $entry_contest_downloads; ?></h4>
            <table class="table table-striped table-border checkout-table">
              <tbody>
                <?php foreach ($contest_downloads as $vcd) { ?>
                  <tr>
                    <th class="hidden"></th>
                    <th><h5 class="product-title font-alt"><?php echo $vcd['name']; ?></h5></th>
                    <td><a class="btn btn-round btn-g pull-right" target="_blank" title="" href="<?php echo $vcd['href']; ?>">Скачать <?php echo $vcd['size']; ?></a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
          
          <?php if (!$is_expert && $contest_status == 1) { ?>
            <div class="row">
              <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                  <a href="<?php echo $im_deal; ?>" class="btn btn-round btn-block btn-success mb-40 mt-20"><?php echo $text_im_deal; ?></a>
                </div>
              </div>  
            </div>
          <?php } ?>
          
          
          </div>
          

        </div>
        <!-- Post end -->
      </div>
      <!-- Content column end -->
       <!-- Sidebar column start -->
      <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
        <?php echo $column_left; ?>
        <?php echo $column_right; ?>
      </div>
      <!-- Sidebar column end -->
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div><!-- /.module -->



<?php echo $footer; ?>