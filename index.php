<!DOCTYPE HTML SYSTEM>

<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="en">

	<head>
		<meta charset="utf-8" />
		<title>Web SMS</title>

		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="icon" type="image/svg+xml" href="img/favicon.svg"/>
	</head>

	<body>

		<?php

		//phpinfo();

		define("DB_HOST", "localhost");
		define("DB_NAME", "webSMS");
		define("DB_USER", "pi");
		define("DB_PASS", "");

		try
		{
			$bdd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS);
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}

		$req2 = $bdd->prepare("UPDATE sms SET sms_status=1 WHERE sms_number LIKE ? AND sms_type=0 ; ");
		$req2->execute(array($_GET["num"]));

		?>

      <header>

		 	<a href="/"><img src="img/title.svg" alt="PiSMS" height="50" ></a>

      </header>

      <nav>

			<?php

			$req = $bdd->prepare("SELECT DISTINCT sms_number FROM sms;");
			$req->execute();

			while ($result = $req->fetch()) {

				$req2 = $bdd->prepare("select count(sms_status) from sms WHERE sms_number LIKE ? and sms_status = 0 ;");
				$req2->execute(array($result['sms_number']));

				$unreadCount = $req2->fetch()['count(sms_status)'] ;

				?>

				<a class="number-link" href="?num=<?php echo urlencode($result['sms_number']) ; ?>">
	            <p class="number-link">
						<?php
						if ($unreadCount > 0) {
							echo "<span class=\"new-msg\">".$unreadCount."</span>" ;
						}
						?>
						<?php echo $result['sms_number'] ; ?>
					</p>
	         </a>

				<?php

			}

			?>

      </nav>

      <section class="sms-conv">

			<?php

			$req = $bdd->prepare("SELECT * FROM sms WHERE sms_number LIKE ? ; ");
			$req->execute(array($_GET["num"]));

			//$result['idTradList']

			while ($result = $req->fetch()) {

				$sms_text = str_replace("\n", "<br />", $result['sms_msg']);

				$dateTime = new DateTime($result['sms_date']);

				$dateTime->setTimezone(new DateTimeZone('Europe/Paris'));

				$timezone = $dateTime->getTimezone();

				if ($result['sms_type'] == 1) {

					?>

					<article class="sms">
		            <div class="sms-sended">
		               <p class="sms-text"><?php echo $sms_text ; ?></p>
		               <p class="sms-date"><?php echo $dateTime->format('d/m/Y H:i:s') ; ?></p>
		            </div>
		         </article>

					<?php

				}
				else {

					?>

					<article class="sms">
		            <div class="sms-received">
		               <p class="sms-text"><?php echo $sms_text ; ?></p>
		               <p class="sms-date"><?php echo $dateTime->format('d/m/Y H:i:s') ; ?></p>
		            </div>
		         </article>

					<?php

				}

			}

			?>

      </section>

      <section class="sms-send">
         <form class="sms-send" action="" method="post">
            <textarea class="sms-send" placeholder="SMS ..." name="name" rows="8" cols="80" disabled></textarea>
            <button class="sms-send" type="button" name="send" disabled><img src="img/send-arrow.svg" alt="Send"></button>
         </form>
      </section>

   </body>

</html>
