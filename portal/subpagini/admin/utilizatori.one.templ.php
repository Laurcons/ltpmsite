<templates>

	<template id="predare-row-template">

		<div class="row table-row border border-bottom-0 {{^hasMaterie}}border-top-0{{/hasMaterie}} p-2">

			<div class="col-md-3">

				<span class="badge badge-primary">{{nrcrt}}</span>
				<span class="badge badge-danger mr-2">{{clasa.predare.Id}}</span>
				{{#hasMaterie}}
					{{materie.Nume}}
				{{/hasMaterie}}
				{{^hasMaterie}}
					<span class="d-md-none">{{materie.Nume}}</span>
				{{/hasMaterie}}

			</div>

			<div class="col-md-3">

				<b>{{clasa.Nivel}}-{{clasa.Sufix}}</b>, diriginte  
				{{clasa.diriginte.Nume}} {{clasa.diriginte.Prenume}}

			</div>

			<div class="col-md-6">

				<a href="/portal/admin/clase/{{clasa.Id}}" class="btn btn-default border-dark btn-sm">Gestionare {{clasa.Nivel}}-{{clasa.Sufix}}</a>

				<button class="btn btn-sm btn-default border-danger"
						data-toggle="modal"
						data-target="#sterge-predare-modal"
						data-predare-id="{{clasa.predare.Id}}">
					Sterge predare
				</button>

			</div>

		</div>

	</template>

</templates>