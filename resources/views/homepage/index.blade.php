<h1> Bienvenue à l’Atelier 404 </h1>
    <p> L’Atelier 404 est un espace dédié à la réparation gratuite des équipements informatiques, 
        ouvert au public et géré par nos étudiants en informatique. 
        Notre objectif est de permettre à chacun de donner une seconde vie à ses appareils tout en 
        offrant aux étudiants une expérience pratique encadrée et supervisée par nos techniciens expérimentés. 
    </p>

<div>
    <h2> Nos services </h2>
    <ul>
        <li>Diagnostic et réparation d’ordinateurs portables et fixes</li>
        <li>Assistance pour smartphones et tablettes</li>
        <li>Récupération de données et sauvegarde</li>
        <li>Installation et mise à jour de logiciels</li>
        <li>Conseils pour l’entretien et l’optimisation des appareils</li>
    </ul>
    <p>Nous accueillons tous les citoyens souhaitant faire réparer leurs équipements dans un cadre convivial et professionnel.</p>
</div>

<div>
    <h2>Formulaire de contact</h2>
    <p>Pour prendre rendez-vous ou soumettre une demande de réparation, merci de remplir notre formulaire :</p>
    <form action ="" method='POST'>

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
<div>
    <h2>Informations pratiques</h2>
    <ul>
        <li>Localisation : Atelier 404, Campus Informatique, [Adresse exacte à compléter]</li>
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
