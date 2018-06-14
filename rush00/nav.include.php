<!-- *********************************************************************** -->
<!--                                                                         -->
<!--                                                      :::      ::::::::  -->
<!-- nav.include.html                                   :+:      :+:    :+:  -->
<!--                                                  +:+ +:+         +:+    -->
<!-- By: amehmeto <marvin@42.fr>                    +#+  +:+       +#+       -->
<!--                                              +#+#+#+#+#+   +#+          -->
<!-- Created: 2018/04/04 03:41:52 by amehmeto          #+#    #+#            -->
<!-- Updated: 2018/04/04 03:41:54 by amehmeto         ###   ########.fr      -->
<!--                                                                         -->
<!-- *********************************************************************** -->

<nav>
	<ul>
		<li><a href="index.php">Accueil</a></li>
		<li><a href="shop.php">Shop</a></li>
		<li><a href="cont_panier.php">Panier</a></li>
	</ul>
	<form id="login_panel" method="post" action="connexion.php">
		<p>Pseudo : <input type="text" name="pseudo" /></p>
		<p>Mot de passe : <input type="password" name="password" /></p>
		<input type="submit" value ="Se connecter" />
		<button><a href=''>Créer un compte</a></button>
	</form>
</nav>
