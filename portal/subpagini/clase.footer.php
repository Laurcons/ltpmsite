<footer>

 	<?php if ($is_list) : ?>

 		<script src="/portal/clase/js/list"></script>
 		<?php include("clase.list.templ.php"); ?>

 	<?php else : ?>

		<div class="modal fade" id="noteaza-modal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<div class="modal-title">
							<h4>Noteaza</h4>
						</div>

					</div>
					<div class="modal-body" id="noteaza-modal-body">

						<p>Sunteti pe cale sa notati elevul <b><span data-for="nume"></span></b>.</p>

						<div class="form-group form-row">

							<label class="col-3 col-form-label font-weight-bold">Nota:</label>

							<div class="col-9">

								<div class="input-group">

									<select class="form-control" form="noteaza-form" name="nota" id="noteaza-modal-nota">

										<option>10</option>
										<option>9</option>
										<option>8</option>
										<option>7</option>
										<option>6</option>
										<option>5</option>
										<option>4</option>
										<option>3</option>
										<option>2</option>
										<option>1</option>

									</select>

								</div>

							</div> <!-- input-group -->

						</div> <!-- form-group -->

						<div class="form-group form-row">

							<label class="col-3 col-form-label font-weight-bold">Data:</label>

							<div class="col-9">

								<div class="input-group">

									<select class="form-control" form="noteaza-form" name="ziua" id="noteaza-modal-ziua">

										<?php
											for ($i = 1; $i <= 31; $i++) {
												echo '<option>';
												if ($i < 10) echo '0';
												echo $i;
												echo '</option>';
											}
										?>

									</select>

									<select class="form-control" form="noteaza-form" name="luna" id="noteaza-modal-luna">

										<?php
											for ($i = 1; $i <= 12; $i++) {
												echo '<option value="' . $i . '">';
												echo '&#' . (8543 + $i) . ';';
												echo '</option>';
											}
										?>

									</select>

								</div> <!-- input group -->

							</div>

							<div class="alert alert-danger p-1 px-2 d-none" data-form="noteaza" data-for="data"></div>

						</div> <!-- form-group -->

						<div class="form-group form-row">

							<label class="col-3 font-weight-bold">Tipul notei:</label>

							<div class="col-9">

								<div class="form-check form-check-inline">

									<input class="form-check-input"
										   type="radio"
										   form="noteaza-form"
										   name="tip"
										   value="oral"
										   id="check-oral"
										   checked>

									<label class="form-check-label" for="check-oral">
										oral
									</label>

								</div>

								<div class="form-check form-check-inline">

									<input class="form-check-input"
										   type="radio"
										   form="noteaza-form"
										   name="tip"
										   value="test"
										   id="check-test">

									<label class="form-check-label" for="check-test">
										test
									</label>

								</div>

								<div class="form-check form-check-inline" id="noteaza-modal-teza">

									<input class="form-check-input"
										   type="radio"
										   form="noteaza-form"
										   name="tip"
										   value="teza"
										   id="check-teza">

									<label class="form-check-label text-danger" for="check-teza">
										teza
									</label>

								</div>

							</div>

						</div> <!-- form-group -->

						<div class="alert alert-danger p-2 d-none" data-form="noteaza" data-for="form"></div>

					</div> <!-- modal-body -->

					<div class="modal-footer">

						<div class="btn-group">

							<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>

							<button type="submit" form="noteaza-form" class="btn btn-primary">
								Noteaza
							</button>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="modal fade" id="anuleaza-nota-modal">
		
			<div class="modal-dialog">
		
				<div class="modal-content">
		
					<div class="modal-header bg-danger">
		
						<h4 class="modal-title text-white">
							Anuleaza nota
						</h4>
		
					</div>
		
					<div class="modal-body" id="anuleaza-nota-modal-body">
		
						<p>Sunteti sigur ca doriti sa anulati nota? Aceasta actiune nu este reversibila!</p>

						<h5>Veti anula nota <span data-name="nota"></span> de pe data de <span data-name="data"></span>!</h5>

						<div class="form-group">

							<label class="font-weight-bold">Confirmati parola contului dvs:</label>

							<input type="password"
								   name="password"
								   form="anuleaza-nota-form"
								   class="form-control">

							<div class="alert alert-danger p-2 d-none" data-form="anuleaza-nota" data-for="password"></div>

						</div>

						<div class="form-group">

							<label class="font-weight-bold">Scrieti motivul pe larg pentru care anulati nota:</label>

							<textarea rows="3"
									  name="reason"
									  form="anuleaza-nota-form"
									  class="form-control"></textarea>

							<small class="mt-1">Va rugam sa detaliati pe cat puteti!</small>

						</div>
		
					</div>
		
					<div class="modal-footer">
		
						<div class="btn-group">
		
							<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Inapoi</button>
		
							<button type="submit"
									form="anuleaza-nota-form"
									class="btn btn-danger">
								Anuleaza nota
							</button>
		
						</div>
		
					</div>
		
				</div>
		
			</div>
		
		</div>

		<div class="modal fade" id="adauga-absenta-modal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<h4>Pune absenta</h4>

					</div>

					<div class="modal-body">

						<p>Selecteaza data pe care doresti sa treci absenta.</p>

						<div class="form-group">

							<div class="input-group">

								<div class="input-group-prepend">

									<div class="input-group-text">
										Data
									</div>

								</div>

								<select class="form-control" form="adauga-absenta-form" name="ziua" id="adauga-absenta-form-ziua">
										
									<?php
										for ($i = 1; $i <= 31; $i++) {
											echo '<option>';
											if ($i < 10) echo '0';
											echo $i;
											echo '</option>';
										}
									?>

								</select>

								<select class="form-control" form="adauga-absenta-form" name="luna" id="adauga-absenta-form-luna">

									<?php
										for ($i = 1; $i <= 12; $i++) {
											echo '<option value="' . $i . '">';
											echo '&#' . (8543 + $i) . ';';
											echo '</option>';
										}
									?>

								</select>

							</div>

						</div>

						<div class="d-none alert alert-danger p-2" data-form="adauga-absenta" data-for="form">
						</div>

					</div>

					<div class="modal-footer">

						<div class="btn-group">

							<button type="button" class="btn bg-white border border-primary" data-dismiss="modal">Inapoi</button>

							<button type="submit" class="btn btn-primary" 
									form="adauga-absenta-form">
								Adauga absenta
							</button>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="modal fade" id="anuleaza-absenta-modal">
		
			<div class="modal-dialog">
		
				<div class="modal-content">
		
					<div class="modal-header bg-danger">
		
						<h4 class="modal-title text-white">
							Anuleaza absenta
						</h4>
		
					</div>
		
					<div class="modal-body" id="anuleaza-absenta-modal-body">

						<p>Sunteti sigur ca doriti sa anulati absenta? Aceasta actiune nu este reversibila!</p>

						<h5>Veti anula absenta de pe data de <span data-name="data"></span>!</h5>

						<div class="form-group">

							<label class="font-weight-bold">Confirmati parola contului dvs:</label>

							<input type="password"
								   name="password"
								   form="anuleaza-absenta-form"
								   class="form-control">

							<div class="alert alert-danger p-2 d-none" data-form="anuleaza-absenta" data-for="password"></div>

						</div>

						<div class="form-group">

							<label class="font-weight-bold">Scrieti motivul pe larg pentru care anulati absenta:</label>

							<textarea rows="3"
									  name="reason"
									  form="anuleaza-absenta-form"
									  class="form-control"></textarea>

							<small class="mt-1">Va rugam sa detaliati pe cat puteti!</small>

						</div>
		
					</div>
		
					<div class="modal-footer">
		
						<div class="btn-group">
		
							<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Inapoi</button>
		
							<button type="submit"
									form="anuleaza-absenta-form"
									class="btn btn-danger">
								Anuleaza absenta
							</button>
		
						</div>
		
					</div>
		
				</div>
		
			</div>
		
		</div>

		<div class="modal fade" id="preferinte-teza-modal">
		
			<div class="modal-dialog">
		
				<div class="modal-content">
		
					<div class="modal-header">
		
						<h4 class="modal-title">
							Preferinte teza
						</h4>
		
					</div>
		
					<div class="modal-body">

						<p>Precizati care dintre urmatorii elevi sustin teza la <?= $materie["Nume"] ?>.</p>
		
						<div class="form-row font-weight-bold">

							<div class="col-6">
								Elevul
							</div>

							<div class="col-3">
								DA
							</div>

							<div class="col-3">
								NU
							</div>

						</div>

						<div id="preferinte-teza-modal-table">
						</div>
		
					</div>
		
					<div class="modal-footer">
		
						<div class="btn-group">
		
							<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>
		
							<button type="submit"
									form="preferinte-teza-form"
									class="btn btn-primary">
								Actualizeaza
							</button>
		
						</div>
		
					</div>
		
				</div>
		
			</div>
		
		</div>

		<div class="modal fade" id="motivari-modal">
		
			<div class="modal-dialog">
		
				<div class="modal-content">
		
					<div class="modal-header">
		
						<h4 class="modal-title">
							Motivări elev
						</h4>
		
					</div>
		
					<div class="modal-body" id="motivari-modal-body">
		
						<!-- insert code here -->
		
					</div>
		
					<div class="modal-footer">

						<span class="spinner spinner-border text-primary mr-3 d-none" id="motivari-modal-spinner"></span>
		
						<div class="btn-group">
		
							<button type="button" class="btn btn-default border-primary" data-dismiss="modal">
								Înapoi
							</button>
		
						</div>
		
					</div>
		
				</div>
		
			</div>
		
		</div>

		<form id="noteaza-form">

			<input type="hidden" name="elev-id">
			<input type="hidden" name="materie-id" value="<?= $materie_id ?>">
			<input type="hidden" name="form-id">
			<input type="hidden" name="semestru" value="<?= $semestru ?>">
			<input type="hidden" name="noteaza">

		</form>

		<form id="anuleaza-nota-form">

			<input type="hidden" name="nota-id">
			<input type="hidden" name="form-id">
			<input type="hidden" name="anuleaza-nota">

		</form>

		<form id="adauga-absenta-form">

			<input type="hidden" name="form-id"> <!-- value="わたしはウィーブです！" -->
			<input type="hidden" name="elev-id">
			<input type="hidden" name="materie-id" value="<?= $materie_id ?>">
			<input type="hidden" name="semestru" value="<?= $semestru ?>">
			<input type="hidden" name="adauga-absenta">

		</form>

		<form id="motiveaza-absenta-form"> 

			<input type="hidden" name="form-id">
			<input type="hidden" name="absenta-id">
			<input type="hidden" name="motiveaza-absenta">

		</form>

		<form id="anuleaza-absenta-form">

			<input type="hidden" name="elev-id">
			<input type="hidden" name="absenta-id">
			<input type="hidden" name="form-id">
			<input type="hidden" name="anuleaza-absenta">

		</form>

		<form id="preferinte-teza-form">

			<input type="hidden" name="form-id">
			<input type="hidden" name="materie-id" value="<?= $materie_id ?>">
			<input type="hidden" name="preferinte-teza">

		</form>

		<form id="sterge-motivare-form">
		
			<input type="hidden" name="form-id">
			<input type="hidden" name="motivare-id">
			<input type="hidden" name="sterge-motivare">

		</form>

	 	<script src="/portal/clase/js/one"></script>
	 	<script>
	 		var semestru = urlGet("sem") ?? <?= getCurrentSemestru() ?>;
	 	</script>

	 	<?php include("clase.one.templ.php"); ?>

	<?php endif; ?>

 </footer>