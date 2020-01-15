## Installation

1. Download, dann die Dateien auf deinen Server kopieren
2. Die Dateien und Verzeichnis mit dem Namen-Anhang «-sample» umbenennen, so dass dieser Anhang weg ist. Das sind folgende fünf:
    * Verzeichnis "episodes-sample" in "episodes" umbennen
    * Verzeichnis "covers-sample" in "covers" umbenennen
    * Datei "config-sample.php" in "config.php" umbenennen
    * Datei "episodes-sample.php" in "episodes.php" umbenennen
    * Datei "cover-sample.jpg" in "cover.jpg" umbenennen
3. Deine Podcast-MP3-Dateien in das Verzeichnis "episodes" kopieren
4. Dein Podcast-Cover-Bild "cover.jpg" nennen und die bereits vorhandende Datei überschreiben
5. Die Konfigurations-Datei "config.json" ausfüllen (Siehe Kapitel "Konfigurationsdatei" weiter unten)
5. Die Datenbank-Datei "episodes.json" mit gescheiten Inhalten füllen (Siehe Kapitel "Datenbank-Datei editieren" weiter unten)
6. Finito (Falls du deinen Podcast noch nicht bei Apple bzw. Spotify registriert hast, siehe Kapitel "Bei Apple bzw. Spotify registrieren" weiter unten.


## Update

1. Neue Dateien downloaden und auf den Server kopieren
2. Vorhandene Dateien überschreiben (Diejenigen Dateien, die nicht überschrieben werden dürfen, werden nicht überschrieben, denn die hatten im Original ja den Namen mit «-sample» dahinter).


## Konfigurationsdatei anpassen

In der Datei "config.php" sind die Grundeinstellungen deines Podcasts gespeichert. Du solltest die Datei also entsprechend anpassen.

WICHTIG: Die Datei muss zwingend eine gültige JSON-Datei bleiben. Notfalls prüfen mit https://jsonlint.com

* **baseUrl**: Deine URL mit "https://" am Anfang, ohne Slash am Ende
* **title**: Der Titel deines Podcasts
* **subtitle**: Untertitel
* **description**: Beschreibung (Zeilenumbrüche mit \n)
* **author**: Dein Name
* **keywords**: Keywords kommagetrennt
* **itunesCategory**: Die Kategorie deines Podcasts. Muss eine Kategorie aus dem iTunes-Universum sein: https://podcasts.apple.com/us/genre/podcasts/id26

* **appleUrl**: Die Direkt-URL zu deinem Podcast im Apple-iTunes-Verzeichnis
* **spotifyUrl**: Die Direkt-URL zu deinem Podcast im Spotify-Verzeichnis

* **email**: Deine E-Mail-Adresse
* **twitter**: Dein Twitter-Link
* **twitterHandle**: Dein Twitter-Handle
* **instagram**: Dein Instagram-Link
* **facebook**: Dein Facebook-Link



## Datenbank-Datei editieren

TBD



## Bei Apple bzw. Spotify registrieren

TBD


## WICHTIG, falls dein Podcast zu erfolgreich wird

* Typische günstige Webhoster sehen es nicht gerne, wenn erfolgreiche Podcast auf ihren Servern gehostet werden. Der Grund: Lange läuft nichts, dann wird eine neue MP3-Datei veröffentlicht, welche relativ gross ist, und dann kommen Tausende von Usern gleichzeitig und laden die MP3-Datei herunter. Deshalb bieten sich die klassischen Podcast-Anbieter an, sobald dein Podcast eine gewisse Zahl von Hörerinnen und Hörern aufweisen kann.
