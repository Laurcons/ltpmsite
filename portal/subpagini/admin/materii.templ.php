<templates>

	<template id="table-row-template">

		<div class="row border border-top-0 p-2">

			<div class="col-md-2">

				<span class="badge badge-primary">{{nrcrt}}</span>
				<!--<snap class="badge badge-danger">{{Id}}</snap>-->
				&nbsp;
				{{Nume}}

			</div>

			<div class="col-md-3">

				{{profesoriStr}}

			</div>

			<div class="col-md-7">

				<button type="button"
						class="btn btn-sm btn-default border-danger"
						data-toggle="modal"
						data-target="#sterge-materie-modal"
						data-materie-id="{{Id}}"
						data-nume-materie="{{Nume}}">
					Sterge materie
				</button>

			</div>

		</div>

	</template>

</templates>