<?php ?>

<div class="container-fluid p-0">

	<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">

		<div class="container">

			<div class="navbar-brand">

				<a class="navbar-brand" href="/portal/">Portal LTPM <small>ALPHA</small></a>

			</div>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-id">

				<span class="navbar-toggler-icon"></span>

			</button>

			<div class="collapse navbar-collapse" id="navbar-id">

				<ul class="navbar-nav mr-auto">

					<?php if (is_logged_in()) : ?>

						<?php if (is_functie("elev")) : ?>

							<li class="nav-item <?= ($header_cpage == 'situatia' ? 'active' : '') ?>" ><a class="nav-link" href="/portal/situatia">Situatia</a></li>

						<?php endif; if (is_autoritate("admin")) : ?>

							<li class="nav-item dropdown">

								<a class="nav-link dropdown-toggle <?= (strpos($header_cpage, 'admin') !== false ? 'active' : '') ?>" href="#" data-toggle="dropdown">Administrare</a>

								<div class="dropdown-menu bg-dark">

									<a class="dropdown-item bg-dark text-light" href="/portal/admin/clase">Clasele liceului</a>

									<a class="dropdown-item bg-dark text-light" href="/portal/admin/materii">Materiile liceului</a>

									<a class="dropdown-item bg-dark text-light" href="/portal/admin/utilizatori">Utilizatori</a>

								</div>

							</li>

						<?php endif; if (is_functie("profesor")) : ?>

							<li class="nav-item <?= ($header_cpage == 'clase' ? 'active' : '') ?>" ><a class="nav-link" href="/portal/clase">Clasele mele</a></li>

						<?php endif; ?>

						<!--<li class="nav-item <?= ($header_cpage == 'citate' ? 'active' : '') ?>" ><a class="nav-link" href="/portal/citate">Propune citat</a></li>-->

						<li class="nav-item <?= ($header_cpage == 'resurse' ? 'active' : '') ?>" ><a class="nav-link" href="/portal/resurse">Resurse</a></li>

					<?php else : ?>

						<!--<li class="nav-item <?= ($header_cpage == 'citate' ? 'active' : '') ?>" ><a class="nav-link" href="/portal/citate">Citate celebre</a></li>-->

					<?php endif; ?>

				</ul>

				<ul class="navbar-nav ml-auto">

					<?php if (is_logged_in()) : ?>

					<li class="nav-item">

						<span class="nav-link">

							<span class="d-md-none d-lg-block">
								Autentificat ca:
								<?= " ".$_SESSION["logatca"] ?>
							</span>
							<span class="d-none d-md-block d-lg-none">
								<?= $_SESSION["logatca"] ?>
							</span>

						</span>

					</li>

					<li class="nav-item"> <a class="nav-link" href="/portal/logout">
						
						<span class="d-none d-md-block">
							<i class="fas fa-sign-out-alt"
								data-toggle="tooltip" data-placement="left" title="Iesire din cont"></i>
							Iesire cont
						</span>
						<span class="d-md-none">
							<i class="fas fa-sign-out-alt"></i> Iesire din cont
						</span>

					</a></li>

					<?php else : ?>

						<li class="nav-item"> <a class="nav-link" href="/portal/logare">

							<span class="d-md-none d-lg-block">
								<i class="fas fa-sign-in-alt"></i>
								Autentificare 
							</span>
							<span class="d-none d-md-block d-lg-none">
								<i class="fas fa-sign-in-alt"></i>
							</span>

						</a></li>

						<li class="nav-item"> <a class="nav-link" href="/portal/inreg">

							<span class="d-md-none d-lg-block">
								<i class="fas fa-user-plus"></i>
								Inregistrare 
							</span>
							<span class="d-none d-md-block d-lg-none">
								<i class="fas fa-user-plus"></i>
							</span>

						</a></li>


					<?php endif; ?>

				</ul>

			</div>

		</div>

	</nav>

</div>