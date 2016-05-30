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
          
          



          <?php if ($contest_status != 0  ) { ?>
           
            <?php if(!empty($winners)) { ?>

             <h4 class="font-alt mb-10"><?php echo ($winner_text)?'Победители':'Финалисты'; ?></h4>
            <table class="table table-striped table-border checkout-table">
              <thead>
              <?php if($contest_type == 3) { ?>
                <tr>
                  <th class="hidden"></th>
                  <th>Название проекта</th>
                  <th>Автор проекта</th>
                  <th>Адаптор проекта</th>
                 
                </tr>
                </thead>
                <tbody>
                <?php foreach ($winners as $vwin) { ?>
                    <tr>
                    <th class="hidden"></th>
                    <td><?php echo $vwin['adaptive_project_title']; ?></td>
                    <td><?php echo $vwin['adaptive_name']; ?></td>
                    <td><?php echo $vwin['customer_name']; ?></td>
                    
                    </tr>
                <?php } ?>
                </tbody>
                
              <?php } else { ?>
                <tr>
                  <th class="hidden"></th>
                  <th>Название проекта</th>
                  <th>Автор проекта</th>
                 
                </tr>
                </thead>
                <tbody>
                <?php foreach ($winners as $vwin) { ?>
                    <tr>
                    <th class="hidden"></th>
                    <td><?php echo $vwin['adaptive_project_title']; ?></td>
                    <td><?php echo $vwin['customer_name']; ?></td>
                    
                    </tr>
                <?php } ?>
                </tbody>
              <?php } ?>
              </table>
            <?php } ?>  


              <?php if($contest_id == 7) {?>
               <h4 class="font-alt mb-10">Победители</h4>
            <table class="table table-striped table-border checkout-table">
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
                <td><a href="/view-project?project_id=128" >"Живые квесты"</a></td>
                <td><a href="/view-group?group_id=271" >Игра головой, Санкт Петербург</a></td>
                <td><a href="/view-group?group_id=283" >Теплые встречи, Киев</a></td>
                <td>Консультации</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="/view-project?project_id=16" >Московский / Екатеринбургский Еврейский Кинофестиваль </a></td>
                <td><a href="/view-group?group_id=356">Ark Pictures, Москва</a></td>
                <td><a href="/view-group?group_id=280" >Гилель, Екатеринбург</a></td>
                <td>Партнерство</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="/view-project?project_id=65" >Творческий процесс</a></td>
                <td><a href="/view-group?group_id=299" >Молодежный клуб Нецер, Москва</a></td>
                <td><a href="/view-group?group_id=281" >Гилель, Санкт Петербург</a></td>
                <td>Консультации</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="/view-project?project_id=63" >Школа еврейского лидерства</a></td>
                <td><a href="/view-group?group_id=299" >Молодежный клуб Нецер, Москва</a></td>
                <td><a href="/view-group?group_id=325" >Хава Нагила, Челябинск</a></td>
                <td>Франчайзинг</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="/view-group?group_id=128" >"Живые квесты"</a></td>
                <td><a href="/view-group?group_id=271" >Игра головой, Санкт Петербург</a></td>
                <td><a href="/view-group?group_id=285">Шиурей Тора Любавич г.Киев</a></td>
                <td>Консультации</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="/view-project?project_id=65" >Творческий процесс </a></td>
                <td><a href="/view-group?group_id=299" >Молодежный клуб Нецер, Москва</a></td>
                <td><a href="/view-group?group_id=319" >SEE THE LIGHT</a></td>
                <td>Франчайзинг</td>
                </tr>
                <tr>
                <th class="hidden"></th>
                <td><a href="/view-project?project_id=106" >Таки Да</a></td>
                <td><a href="/view-group?group_id=276" >ОА Vulturas г. Кишинев</a></td>
                <td><a href="/view-group?group_id=356">Еврейская община г. Жмеренка</a></td>
                <td>Консультации</td>
                </tr>
                </tbody>
                <?php } ?>

                <?php if($contest_id == 8) { ?>
                  <h4 class="font-alt mb-10">Победители</h4>
            <table class="table table-striped table-border checkout-table">
                    <thead>
                    <tr><th class="hidden"></th><th>Название проекта</th><th>Автор</th><th>Адаптор</th></tr>
                    </thead>
                    <tbody>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >COFFEE&amp;BRAIN</a></td>
                    <td><a href="/view-group?group_id=271" >МЕОД (Молодежное Еврейское Образование Днепропетровска)</a></td>
                    <td><a href="/view-group?group_id=271" >Гилель, Хабаровск</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=128" >Живые Квесты</a></td>
                    <td><a href="/view-group?group_id=271" >Игра головой, Санкт Петербург</a></td>
                    <td><a href="/view-group?group_id=283" >Подарок Киев</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=128" >Живые Квесты</a></td>
                    <td><a href="/view-group?group_id=271" >Игра головой, Санкт Петербург</a></td>
                    <td><a href="/view-group?group_id=280" >ЕСКЦ «Гилель» г. Симферополь</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Memory|Art</a></td>
                    <td><a href="/view-group?group_id=271" >Сохнут Киев</a></td>
                    <td><a href="/view-group?group_id=271" >Гилель, Москва</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Проект «TextNext»</a></td>
                    <td><a href="/view-group?group_id=271" >JewF.I.S.H. Project, Москва</a></td>
                    <td><a href="/view-group?group_id=271" >Культурно-Образовательное Сообщество «Миграш-Балтия», Рига</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Проект «TextNext»</a></td>
                    <td><a href="/view-group?group_id=271" >JewF.I.S.H. Project, Москва</a></td>
                    <td><a href="/view-group?group_id=271" >Migrash.Community of practice Самара</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Проект «TextNext»</a></td>
                    <td><a href="/view-group?group_id=271" >JewF.I.S.H. Project, Москва</a></td>
                    <td><a href="/view-group?group_id=271" >Гилель, Петербург</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >CВОБОДА ОБРАЗОВАНИЯ</a></td>
                    <td><a href="/view-group?group_id=271" >Migrash.Community of practice Самара</a></td>
                    <td><a href="/view-group?group_id=271" >ОО Амута, Харьков</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Семь Сорок</a></td>
                    <td><a href="/view-group?group_id=271" >ОО «Амута», Харьков</a></td>
                    <td><a href="/view-group?group_id=271" >Шиурей Тора Любавич, Днепропетровск</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Таки ДА</a></td>
                    <td><a href="/view-group?group_id=271" >AO «Vulturas», Кишинев</a></td>
                    <td><a href="/view-group?group_id=271" >ОО «Тульский областной еврейский благотворительный Центр «Хасдэй Нэшама»\»Милосердие», Тула</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Таки ДА</a></td>
                    <td><a href="/view-group?group_id=271" >AO «Vulturas», Кишинев</a></td>
                    <td><a href="/view-group?group_id=271" >ВГОБО «Еврейский общинный центр», Волгоград</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >Шабат Хост</a></td>
                    <td><a href="/view-group?group_id=271" >Мидраша Ционит, Киев</a></td>
                    <td><a href="/view-group?group_id=271" >МЕОД (Молодежное Еврейское Образование Днепропетровска)</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >«Школа еврейского лидерства»</a></td>
                    <td><a href="/view-group?group_id=271" >НЕЦЕР России, Москва</a></td>
                    <td><a href="/view-group?group_id=271" >Еврейская община Калининграда</a></td>
                    </tr>
                    </tbody>
                  
                  <?php } ?>

               <?php if($contest_id == 6) {?>
                <h4 class="font-alt mb-10">Победители</h4>
            <table class="table table-striped table-border checkout-table">
                   <thead>
                    <tr><th class="hidden"></th><th>Название проекта</th><th>Автор</th><th>Адаптор</th></tr>
                    </thead>
                    <tbody>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=125" >ПОДАРОК</a></td>
                    <td><a href="/view-group?group_id=272" >Подарок, Киев</a></td>
                    <td><a href="/view-group?group_id=283" >Теплые встречи, Киев</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=89" >JEWISH PROFESSIONAL NETWORKING</a></td>
                    <td><a href="/view-group?group_id=282" >Гилель Москва</a></td>
                    <td><a href="/view-group?group_id=334" >Platinum Одесса</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=65" >Творческий процесс</a></td>
                    <td><a href="/view-group?group_id=299" >Молодежный клуб Нецер Москва</a></td>
                    <td><a href="/view-group?group_id=332" >Творческая мастерская диалога еврейскрй и европейской культур: Талмуд – Театр – Текст (ТТТ), Москва</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=128" >Образовательные ролевые игры «Живые квесты»</a></td>
                    <td><a href="/view-group?group_id=271" >Игра головой, Санкт Петербург</a></td>
                    <td><a href="/view-group?group_id=299" >Молодежный клуб Нецер Москва</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=43" >Неформальная театральная студия</a></td>
                    <td><a href="/view-group?group_id=355" >Неформальная театральная студия "Точка Сборки», Киев</a></td>
                    <td><a href="/view-group?group_id=279" >НЭШАРИМ КИШИНЕВ, Кишинев</a></td>
                    </tr>
                    <tr>
                    <th class="hidden"></th>
                    <td><a href="/view-project?project_id=107" >Интеллектуальное казино</a></td>
                    <td><a href="/view-group?group_id=279" >НЭШАРИМ КИШИНЕВ, Кишинев</a></td>
                    <td><a href="/view-group?group_id=330" >Менора, Екатеринбург</a></td>
                    </tr>
                    </tbody>
                  <?php } ?>
            </table>

          <?php } ?>


          <?php if (!$is_expert && $contest_status == 1 && $send_request) { ?>
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
                    <th><?php echo $entry_contest_date_finalist; ?> :</th>
                    <td><?php echo $contest_date_finalist; ?></td>
                  </tr>
                  <tr>
                    <th class="hidden"></th>
                    <th><?php echo $entry_contest_date_result; ?> :</th>
                    <td><?php echo $contest_date_result; ?></td>
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

            <h4 class="font-alt mb-10">Бюджет конкурса</h4>

            <table class="table table-striped table-border checkout-table">
              <tbody>
                <tr>
                  <th class="hidden"></th>
                  <th>Максимальная сумма гранта :</th>
                  <td><?php echo $maxprice; ?></td>
                </tr>
                <tr>
                  <th class="hidden"></th>
                  <th>Общий объем финансирования :</th>
                  <td><?php echo $totalprice; ?></td>
                </tr>
              </tbody>
            </table>
          

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

          <?php if (!$is_expert && $contest_status == 1 && $send_request) { ?>
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
