<templates>

	<template id="clasa-card-template">

		<div class="card w-100">

			<div class="card-body">

				<h4 class="card-title">Clasa {{clasa.Nivel}}-{{clasa.Sufix}} - {{Nume}}</h4>

			</div>

			<ul class="list-group list-group-flush border-top">

				<li class="list-group-item">In calitate de: <b class="text-capitalize">{{calitateDe}}</b></li>

				<li class="list-group-item">Ore pe saptamana: 420</li>

				<li class="list-group-item">Numar elevi: {{nrelevi}}</li>

			</ul>

			<div class="card-body">

				<a class="btn btn-primary w-100"
				   href="/portal/clase/{{Id}}">
					Acceseaza
				</a>

			</div>

		</div> 

	</template>

</templates>