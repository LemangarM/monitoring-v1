<?php
define("ID_GLOBAL", "0999APPEL");
/*
  Author LEMANGAR
 */

class Charts
{

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAppNameList()
    {
        $query = "
            SELECT DISTINCT appIdAllStore, appName
            FROM apps_infos
            ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function appName($id_global= ID_GLOBAL)
    {
        $query = "
            SELECT DISTINCT appIdAllStore, appName
            FROM apps_infos
            WHERE appIdAllStore = :id_global
            ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    /*
     * Table infos générales
     */

    public function InfosAndroid($id_global=ID_GLOBAL)
    {
        $query = "
            SELECT a.appID, appVersion, appMinimumOsVersion, appTotalStars, Unites_total, Unites_cumul, currentVersionReleaseDate
            FROM appstore a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            LEFT JOIN sales_cumul c ON a.appID=c.appID
            WHERE b.appIdAllStore = :id_global
                AND a.appID LIKE '%00%'
            ORDER BY c.DateMeasure DESC LIMIT 1
               ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    public function InfosIos($id_global=ID_GLOBAL)
    {
        $query = "
            SELECT a.appID, appVersion, appMinimumOsVersion, appTotalStars, Unites_total, Unites_cumul, currentVersionReleaseDate
            FROM appstore a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            LEFT JOIN sales_cumul c ON a.appID=c.appID
            WHERE b.appIdAllStore = :id_global
                AND a.appID NOT LIKE '%00%'
            ORDER BY c.DateMeasure DESC LIMIT 1
               ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    /*
     * Install & uninstall & upgrade line chart
     */

    public function getSalesAndroid($id_global=ID_GLOBAL)
    {
        $query = "
            SELECT a.appID, DateMeasure, Unites, Daily_uninstall, Daily_upgrade
            FROM appstore_sales a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = :id_global
               AND a.appID LIKE '%00%'
            ORDER BY DateMeasure DESC LIMIT 31
            ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    public function getSalesIos($id_global=ID_GLOBAL)
    {
        $query = "
            SELECT a.appID, DateMeasure, Unites
            FROM appstore_sales a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = :id_global
                AND a.appID NOT LIKE '%00%'
            ORDER BY DateMeasure DESC LIMIT 31
            ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    /*
     * Visitors bar chart
     */

    public function getVisitorsAndroid($id_global=ID_GLOBAL)
    {
        $query = "
           SELECT a.appID,Unites, DateMeasure
           FROM appstore_uvisitor a
           LEFT JOIN apps_infos b ON a.appID=b.appID
           WHERE b.appIdAllStore = :id_global
               AND a.appID LIKE '%00%'
           ORDER BY DateMeasure DESC LIMIT 7
           ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    public function getVisitorsIos($id_global=ID_GLOBAL)
    {
        $query = "
           SELECT a.appID,Unites, DateMeasure
           FROM appstore_uvisitor a
           LEFT JOIN apps_infos b ON a.appID=b.appID
           WHERE b.appIdAllStore = :id_global
               AND a.appID NOT LIKE '%00%'
           ORDER BY DateMeasure DESC LIMIT 7
           ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    /*
     * Notes line chart
     */

    public function getNotesAndroid($id_global=ID_GLOBAL)
    {
        $query = "
            SELECT a.appID, DateMeasure, Daily_Average_Rating, Total_Average_Rating
            FROM apps_ratings a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = :id_global
            and a.appID LIKE '%00%'
            ORDER BY DateMeasure desc limit 12
            ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

    public function getNotesIos($id_global=ID_GLOBAL)
    {
        $query = "
            SELECT a.appID, DateMeasure, Total_Average_Rating
            FROM apps_ratings a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = :id_global
            and a.appID NOT LIKE '%00%'
            ORDER BY DateMeasure desc limit 12
            ";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_global", $id_global);
        $stmt->execute();

        return $stmt;
    }

}
