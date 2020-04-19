<templates>
 <template id="nota-list-template">

 	{{#note}}
 	
 	<span class="dropdown">

		<span class="float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: {{size}}rem; cursor: {{cursor}};"
			data-toggle="dropdown" data-boundary="viewport">

			<h4 class="text-center">{{Nota}} <small>{{Ziua}} {{Luna}}</small></h4>

		</span>

		<div class="dropdown-menu">

			<a class="dropdown-item text-weight-bold">Inchide</a>
			<div class="dropdown-divider"></div>
			<!--<a class="dropdown-item">Acordata la {{Ziua}} {{Luna}}</a>-->
			<button class="dropdown-item bg-danger text-light"
				type="submit"
				form="anuleaza-nota-form"
				id="anuleaza-nota-{{Id}}">
				Sterge nota
			</button>

		</div>

		<script>

			$(document).ready(function() {
				var nota_id = {{Id}};
				var elev_id = {{IdElev}} ;
				linkNotaToForms(nota_id, elev_id);
			});

		</script>

	</span>

	{{/note}}

 </template>

 <template id="nota-plus-template">

	<span class="float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 2.5rem; cursor: pointer;">

		<h4 class="text-center">+</h4>

	</span>

 </template>

 <template id="absenta-list-template">

 	{{#absente}}

 	<span class="dropdown">

		<div class="d-inline float-left border border-secondary 
			{{^Motivata}}bg-white{{/Motivata}}
			{{#Motivata}}bg-secondary text-light{{/Motivata}}
		 	rounded p-1 mr-1 mb-1" style="width: {{size}}rem; cursor: {{cursor}};"
			data-toggle="dropdown" data-boundary="viewport">

			<h4 class="text-center">{{Ziua}} <small>{{Luna}}</small></h4>

		</div>
		<div class="dropdown-menu">

			<a class="dropdown-item">Inchide</a>
			<button class="dropdown-item bg-primary text-light my-3"
				form="motiveaza-absenta-form"
				type="submit"
				id="motiveaza-absenta-{{Id}}">
				{{#Motivata}}
					Demotiveaza absenta
				{{/Motivata}}
				{{^Motivata}}
					Motiveaza absenta
				{{/Motivata}}
			</button>
			<button class="dropdown-item bg-danger text-light"
				form="anuleaza-absenta-form"
				type="submit"
				id="anuleaza-absenta-{{Id}}">
				Sterge absenta
			</button>

		</div>

		<script>

			$(document).ready(function() {

				var elev_id = {{IdElev}};
				var absenta_id = {{Id}};
				linkAbsentaToForms(elev_id, absenta_id);

			});

		</script>

	</span>

	{{/absente}}

 </template>

 <template id="absenta-plus-template">

	<div class="d-inline float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 2.5rem; cursor: pointer;">

		<h4 class="text-center">+</h4>

	</div>

 </template>
</templates>