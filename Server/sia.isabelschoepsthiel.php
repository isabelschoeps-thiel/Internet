<?php
SIA SECURITY INTELLIGENCE SERVER – PRP Field Module
Autorin: Isabel Schöps, geborene Thiel
 Signatur: INT-CODE-2025-BTC/ETH-CORE-ISABELSCHOEPSTHIEL
Zweck: Prüft eingehende Datenfelder auf Berechtigung und schützt vor Manipulation.
Keine externen API-Zugriffe erlaubt. Kein Cloning. Kein Cronjob. Nur verifizierte Requests.
ACHTUNG: Diese Datei darf nur lokal ausgeführt werden. Kein öffentlicher Zugriff erlaubt.
Eigentum: Isabel Schöps Thiel – INT-CODE-2025-BTC/ETH-CORE-ISABELSCHOEPSTHIEL
Jegliche Weiterverwendung oder externe Verbindung wird strafrechtlich verfolgt.
    

class PRPField
{
    private $allowedIps = ['127.0.0.1']; // Später: dynamisch mit RegionLock
    private $authKey = 'INT-CODE-2025-BTC/ETH-CORE-ISABELSCHOEPSTHIEL';

    public function validate($field, $signature)
    {
        if (!in_array($_SERVER['REMOTE_ADDR'], $this->allowedIps)) {
            $this->deny('Unzulässiger Zugriff – IP nicht autorisiert.');
        }

        if ($signature !== $this->authKey) {
            $this->deny('Signatur ungültig.');
        }

        if (!$this->isPlausible($field)) {
            $this->deny('Feldinhalt manipuliert oder nicht zugelassen.');
        }

        return true;
    }

    private function isPlausible($field)
    {
        // Beispiel für einfache Manipulationsprüfung:
        return is_string($field) && strlen($field) < 256 && !preg_match('/[^\w\s\-]/', $field);
    }

    private function deny($message)
    {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode([
            'status' => 'denied',
            'reason' => $message,
            'owner' => 'Isabel Schöps Thiel',
        ]);
        exit;
    }
}
// ACHTUNG: Diese Datei darf nur lokal ausgeführt werden. Kein öffentlicher Zugriff erlaubt.
// Eigentum: Isabel Schöps Thiel – INT-CODE-2025-BTC/ETH-CORE-ISABELSCHOEPSTHIEL
// Jegliche Weiterverwendung oder externe Verbindung wird strafrechtlich verfolgt.
