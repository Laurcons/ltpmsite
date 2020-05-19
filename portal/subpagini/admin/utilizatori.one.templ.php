<templates>

	<template id="materie-row-template">

		<div class="row table-row border border-top-0 p-2">

			<div class="col-md-3">

				<span class="badge badge-primary">{{nrcrt}}</span>
				<span class="badge badge-danger mr-2">{{Id}}</span>
				{{Nume}}

			</div>

			<div class="col-md-3">

				<b>{{clasa.Nivel}}-{{clasa.Sufix}}</b>, diriginte  
				{{clasa.diriginte.Nume}} {{clasa.diriginte.Prenume}}

			</div>

			<div class="col-md-2">

				{{tipTeza}}

			</div>

			<div class="col-md-4">

				<a href="/portal/admin/clase/{{clasa.Id}}" class="btn btn-default border-dark btn-sm">Gestionare {{clasa.Nivel}}-{{clasa.Sufix}}</a>

				<button class="btn btn-default border-primary btn-sm"
						onclick="alert('Neimplementat!');">
					Redenumește
				</button>

				<button class="btn btn-sm btn-default border-danger"
						data-toggle="modal"
						data-target="#sterge-materie-modal"
						data-materie-id="{{Id}}">
					Șterge materie
				</button>

			</div>

		</div>

	</template>

</templates>