<!-- Widgets start -->
		<div class="module module--footer module--bg-dark">
			<div class="container">

				<div class="row">

					<div class="col-sm-3">

						<!-- Widget start -->
						<div class="widget">
							<h5 class="widget-title font-alt">Контактная информация</h5>

							<p>Телефон: +9 72-262 163 29<br>Телефон: +9 72-262 160 66</p>
							<p>Email: <a href="mailto:info@jewish-grassroots.org">info@jewish-grassroots.org</a></p>
						</div>
						<!-- Widget end -->

					</div>

					<div class="col-sm-3">

						<!-- Widget start -->
						<div class="widget hidden">
							<h5 class="widget-title font-alt">Recent Comments</h5>
							<ul class="icon-list">
								<li>Maria on <a href="#">Designer Desk Essentials</a></li>
								<li>John on <a href="#">Realistic Business Card Mockup</a></li>
								<li>Andy on <a href="#">Eco bag Mockup</a></li>
								<li>Jack on <a href="#">Bottle Mockup</a></li>
								<li>Mark on <a href="#">Our trip to the Alps</a></li>
							</ul>
						</div>
						<!-- Widget end -->

					</div>
					<div class="col-sm-3 ">

						 <!-- Widget start -->
				        <div class="widget ">

				        </div>
				        <!-- Widget end -->

					</div>
					<div class="col-sm-3">
						<!-- Widget start -->
				        <div class="widget ">
				          <h5 class="widget-title font-alt">Анонсы</h5>
				          <ul class="widget-posts">
				      		<?php foreach ($anons as $news) { ?>
								 <li class="clearfix">
						              <div class="widget-posts-image">
						                <a href="<?php echo $news['view']; ?>">
											<img src="<?php echo $news['image']; ?>" alt="">
										</a>
						              </div>
						              <div class="widget-posts-body">
						                <div class="widget-posts-title">
						                 <a href="<?php echo $news['view']; ?>"><?php echo $news['title']; ?></a>
						                </div>
						                <div class="widget-posts-meta">
						                  <?php echo $news['date_added']; ?>
						                </div>
						              </div>
						            </li>
							  <?php } ?>
				          </ul>
				        </div>
				        <!-- Widget end -->

					</div>



				</div><!-- .row -->

			</div>
		</div>
		<!-- Widgets end -->

		<!-- Divider -->
		<hr class="divider-d">
		<!-- Divider -->

		<!-- Footer start -->
		<div class="module module--min-footer module--bg-dark ">
			<div class="container">

				<div class="row">

					<div class="col-sm-6">
						<p class="copyright font-alt">© 2012 г. Jewis-grassroots,  Все права защищены</p>
					</div>

					<div class="col-sm-6">
						<div class="footer-social-links hidden">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-skype"></i></a>
						</div>
					</div>

				</div><!-- .row -->

			</div>
		</div>
		<!-- Footer end -->
</div><!-- /.Wrapper end -->
<!-- Modal -->
<div class="modal fade" id="first_step_deal_bp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title font-alt" id="myModalLabel">Уведомление</h4>
	</div>
	<div class="modal-body" id="body_modal">
		<p class="font-alt text-center">Вы хотите добавить проект в общий пул проектов конкурса?</p>
    <div class="row ">
      <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
          <button class="btn btn-round btn-block btn-success mb-40 mt-20" id="send_project_to_pull">Подтвердить</button>
        </div>
      </div>
    </div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal" id="close_send_project_to_pull">Закрыть</button>
	</div>
</div>
</div>
</div>


    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title font-alt" id="myModalLabel">Подтверждение выбора</h4>
      </div>
      <div class="modal-body" id="body_modal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel_choose">Выбрать другой проект</button>
      </div>
    </div>
  </div>
</div>

    <!-- Modal -->
<div class="modal fade" id="alert-send-best" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title font-alt" id="myModalLabel">Уведомление</h4>
      </div>
      <div class="modal-body" id="body_modal">
			Для участия в конкурсе, необходимо добавить свой проект в общий пулл конкурса.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить</button>
      </div>
    </div>
  </div>
</div>
<!-- Scroll-up -->
<div class="scroll-up">
	<a href="#totop"><i class="fa fa-angle-double-up"></i></a>
</div>
<script src="catalog/view/theme/jewish/assets/js/jewish.min.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
  <script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">
   function pingServer() {
      $.ajax({ url: location.href });
   }
   $(document).ready(function() {
      setInterval('pingServer()', 60000);
   });
</script>
</body></html>
