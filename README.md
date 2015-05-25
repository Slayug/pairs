# pairs
Projet L1/L2 UFR Blois

<h2>Contexte</h2>
<p>Ce site permet aux étudiants d'évaluer l’organisation, la distribution
du travail et l’implication de chaque étudiant d'un groupe. Cela se fait lors des soutenances mais aussi au quotidien.
Ce site offre aux professeurs un moyen de créer des questionnaires. Chaque groupe d'étudiants pourra ensuite y répondre pour évaluer ses pairs.</p>

<h2>Réalisation</h2>
<p>Ce site a été réalisé lors du Projet L1-L2 à l'UFR de Blois.</p>
<ul>
	<li>BENRAGDEL Nizar (nbenragdel)</li>
	<li>CAMILA MOLINA Maria (MCMolina)</li>
	<li>PURET Alexis (Slayug)</li>
	<li>Sabed Adib (?)</li>
	<li>RAYMONT Yann (?)</li>
	<li>TRAORE Mbarré (mbarrelinovic)</li>
	<li>TURE Mama (mama41)</li>
</ul>

<h2>Installation</h2>
<h4>Conditions requises:</h4>
<ul>
	<li>HTTP Server</li>
	<li>PHP 5.4.16+</li>
	<li>MySQL (5.1.10 ou supérieur)+</li>
	<li>extension mbstring</li>
	<li>extension intl</li>
	<li>extension mod_rewrite</li>
</ul>
<p>Le site fonctionne sous le framwork CakePHP 3.0 il suffit donc de cloner les fichiers dans un répertoire d'un serveur web.<br>
Par exemple sous lampp, ouvrir un terminal, se placer dans /opt/lampp/htdocs<br>
Sous wamp, */wamp/www et faire: <strong>git clone https://github.com/Slayug/pairs</strong></p>

<p>Vous devez aussi importer les tables, le fichier d'importation est dans le dossier sql <cake_pairs_en.sql>. Une fois le fichier téléchargé, il doit être importé dans la base de données: <cake_pairs>.</p>
<p>Les informations de connexion à la base de données se trouvent dans /config/app.php l.210 si vous souhaitez les modifier.</p>

<h4>Problème récurrent</h4>
<p>Avec XAMPP et WAMP, les extensions mcrypt et mbstring fonctionnent par défaut.
Dans XAMPP, l’extension intl est incluse mais vous devez décommenter extension=php_intl.dll dans php.ini et redémarrer le serveur dans le Panneau de Contrôle de XAMPP.
Dans WAMP, l’extension intl est “activée” par défaut mais ne fonctionne pas. Pour la faire fonctionner, vous devez aller dans le dossier php (par défaut) C:\wamp\bin\php\php{version}, copiez tous les fichiers qui ressemblent à icu*.dll et collez les dans le répertoire bin d’apache C:\wamp\bin\apache\apache{version}\bin. Ensuite redémarrez tous les services et tout devrait être OK.
</p>
<p>Source: <a href="http://book.cakephp.org/3.0/fr/installation.html#conditions-requises">cakePHP</a></p>


