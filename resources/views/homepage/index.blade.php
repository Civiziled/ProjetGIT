<x-public-layout>
<div class="title">
    <nav>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
        <a href="#infos">FAQ</a>
       <a href='{{ route('dashboard') }}'>Profil</a>
    </nav>
<h1> Bienvenue à l’Atelier 404 </h1>
    <p> L’Atelier 404 est un espace dédié à la réparation gratuite des équipements informatiques, 
        ouvert au public et géré par nos étudiants en informatique. 
        Notre objectif est de permettre à chacun de donner une seconde vie à ses appareils tout en 
        offrant aux étudiants une expérience pratique encadrée et supervisée par nos techniciens expérimentés. 
    </p>
</div>
<div class="service" id="service">
    <h2>Nos services</h2>

    <section class="service-grid">
        <div class="service-item">
                <i class="ri-computer-line"></i>
            <p>Diagnostic et réparation d’ordinateurs portables et fixes</p>
        </div>

        <div class="service-item">
                <i class="ri-smartphone-line"></i>
            <p>Assistance pour smartphones et tablettes</p>
        </div>

        <div class="service-item">
                <i class="ri-database-2-line"></i>
            <p>Récupération de données et sauvegarde</p>
        </div>

        <div class="service-item">
                <i class="ri-tools-line"></i>
            <p>Installation et mise à jour de logiciels</p>
        </div>

        <div class="service-item">
                <i class="ri-lightbulb-flash-line"></i>
            <p>Conseils pour l’entretien et l’optimisation des appareils</p>
        </div>
    </section>

    <p class='pt-6'>
        Nous accueillons tous les citoyens souhaitant faire réparer leurs équipements dans un cadre convivial et professionnel.
    </p>
</div>

<div class='contact-section' id="contact">
    <h2>Formulaire de contact</h2>
    <p>Pour prendre rendez-vous ou soumettre une demande de réparation, merci de remplir notre formulaire :</p>
    <form action ="{{ route('public.store') }}" method='POST' class='contact-form'>

        @csrf
        <div>
            <label for='name'>Nom et prénom :</label>
            <input type="text" id="name" name='name' value='{{ old('name') }}' required>
            @error ('name')
              <div> {{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
              <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
            @error('phone')
              <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="device_type">Type d'appareil :</label>
            <select id="device_type" name="device_type" required>
              <option value="">-- Sélectionnez --</option>
              <option value="ordinateur">Ordinateur</option>
              <option value="smartphone">Smartphone</option>
              <option value="tablette">Tablette</option>
              <option value="autre">Autre</option>
            </select>
            @error('device_type')
              <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="problem_description">Description du problème :</label>
            <textarea id="problem_description" name="problem_description" required>{{ old('problem_description') }}</textarea>
            @error('problem_description')
              <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
           <button type="submit">Envoyer la demande</button>
        </div>
    </form>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif
<div class="infos" id="infos">
    <h2>Informations pratiques</h2>
    <ul>
        <li>Localisation : Atelier 404, Campus Informatique</li>
        <li>Horaires d’ouverture : Lundi à vendredi, 10h00 – 18h00</li>
        <li> FAQ rapide : 
            <ul>
                <li>Puis-je apporter plusieurs appareils ? Oui, mais chaque appareil doit être soumis individuellement.</li>
                <li>Faut-il prendre rendez-vous ? Le formulaire en ligne suffit pour enregistrer votre intervention.</li>
                <li>Combien de temps dure une réparation ? Cela dépend du problème, mais un suivi est toujours assuré.</li>
            </ul>
        </li>
    </ul>
    <p>Nous vous invitons à découvrir l’Atelier 404 et à profiter de nos services gratuits, tout en soutenant l’apprentissage pratique de nos étudiants en informatique.</p>
</div>

</x-public-layout>