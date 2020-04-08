
<?php if ($current_id == -1) : ?>

	<templates>

		<template id="clasa-template">

			<div class="col-md-4 mb-2">

					<div class="card" style="/*box-shadow: 5px 5px 5px #aaa;*/"> 

						<div class="card-header">

							<div class="card-title h4">

								Clasa {{Nivel}} {{Sufix}}

								<button type="button" class="close" id="sterge-clasa-button-{{Id}}">
									&times;
								</button>

							</div>

						</div>

						<ul class="list-group list-group-flush">

							<li class="list-group-item"><b>Diriginte:</b> {{diriginte.Nume}} {{diriginte.Prenume}}</li>

							<li class="list-group-item"><b>Numar elevi:</b> {{nrelevi}}</li>

						</ul>

						<div class="card-body">

							<a class="btn btn-primary w-100" href="?p=admin:clase&id={{Id}}">Administreaza</a>

						</div>

					</div>

				</div>

		</template>

		<template id="creeaza-clasa-modal-allowed-template">

			<div class="modal-header">

				<div class="modal-title h4">
					Adaugare clasa
				</div>

			</div> <!-- modal-header -->

			<div class="modal-body">

				<p>Pentru inceput, vom avea nevoie de putine detalii despre clasa.</p>

				<div class="form-group">

					<label>Denumirea clasei:</label>

					<div class="input-group">

						<input id="creeaza-clasa-form-nivel"
						       form="creeaza-clasa-form"
						       name="nivel"
						       class="form-control"
						       type="text"
						       placeholder="Nivelul (ex. 0, 1, 10, 12, etc.)">

						<input id="creeaza-clasa-form-sufix"
						       form="creeaza-clasa-form"
						       name="sufix"
						       class="form-control"
						       oninput="this.value = this.value.toUpperCase();"
						       type="text"
						       placeholder="Sufixul (ex. A, B, C, etc.)">

					</div>

					<div class="alert alert-danger mt-1 p-1 pl-3 d-none" data-form="creeaza-clasa" data-for="denumire">

						<!-- filled with javascript -->

					</div>

				</div>

				<div class="form-group">

					<label>Anul scolar:</label>

					<select id="creeaza-clasa-form-an"
							form="creeaza-clasa-form"
							name="an"
							class="form-control">

						<?php $year = date('Y');
							for ($i = $year-5; $i < $year+5; $i++) {
								echo '<option value="'.$i.'"'.($i==2019?' selected':'').'>'.$i.'-'.($i+1).'</option>';
							}
						?>

					</select>

				</div>

				<div class="form-group">

					<label>Profesorul diriginte:</label>

					<select id="creeaza-clasa-form-idprofesor"
							form="creeaza-clasa-form"
							name="iddiriginte"
							class="form-control">

						<!-- filled with javascript -->

					</select>

				</div>

			</div> <!-- modal-body -->

			<div class="modal-footer">

				<div class="btn-group">

					<button class="btn btn-default bg-white border-primary" data-dismiss="modal">Inapoi</button>

					<input type="submit"
						   form="creeaza-clasa-form"
						   class="btn btn-primary"
						   value="Adauga clasa">

				</div>

			</div>

		</template>

		<template id="creeaza-clasa-modal-disallowed-template">

			<div class="modal-body">

				<p>Nu puteti crea clase noi, deoarece nu aveti profesori disponibili care sa le fie diriginti!</p>

				<p>Va rugam sa creati conturi noi pentru profesori, si incercati din nou.</p>

			</div>

			<div class="modal-footer">

				<button class="btn btn-default bg-white border-primary" data-dismiss="modal">Inapoi</button>

			</div>

		</template>

	</templates>

<?php else : // current_id == -1 ?>

	<templates>

		<template id="elev-template">

			<div class="row border{{^first}} border-top-0{{/first}} p-2">

				<div class="col-md-4">

					<div class="d-none d-md-block">

						<span class="badge badge-primary mr-1">{{nrcrt}}</span>

						{{Nume}} {{Prenume}}

					</div>
					<div class="d-block d-md-none h5">

						<span class="badge badge-primary mr-1">{{nrcrt}}</span>

						{{Nume}} {{Prenume}}

					</div>

				</div>

				<div class="col-md-6">

					<div class="d-md-none font-weight-bold">
						Optiuni:
					</div>

					<a href="?p=admin:utilizatori&id={{Id}}" class="btn btn-sm border-info">Detalii elev</a>

					<button class="btn btn-sm border-danger">Sterge din clasa</button>

				</div>

			</div>

		</template>

		<template id="predare-template">

			<div class="row border p-2 {{^first}}border-top-0{{/first}}">

				<div class="col-md-4">

					<div class="d-none d-md-block">

						<span class="badge badge-primary mr-1">{{nrcrt}}</span>

						{{materie.Nume}}

					</div>
					<div class="d-block d-md-none h5">

						<span class="badge badge-primary mr-1">{{nrcrt}}</span>

						{{materie.Nume}}

					</div>

				</div>

				<div class="col-md-3">

					<span class="d-block d-md-none"><b>Predata de:</b> {{profesor.Nume}} {{profesor.Prenume}}</span>
					<span class="d-none d-md-block">{{profesor.Nume}} {{profesor.Prenume}}</span>

				</div>

				<div class="col-md-5">

					<a href="?p=admin:utilizatori&id={{profesor.Id}}" class="btn btn-sm border-info">Detalii profesor</a>

					<button class="btn btn-sm border-danger">Sterge predare</button>

				</div>

			</div>

		</template>

	</templates>

<?php endif; ?>