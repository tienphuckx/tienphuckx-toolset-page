<?php
// session_start();
// if (isset($_POST['screen_resolution'])) {
//     $_SESSION['screen_resolution'] = $_POST['screen_resolution'];
//     echo 'Screen resolution received and stored';
//     exit;
// }

// _collect_visitor_data($conn);
function _collect_visitor_data($conn)
{
    function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    function getBrowserInfo()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    function getOperatingSystem()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'Mac';
        } elseif (preg_match('/windows|win32/i', $userAgent)) {
            return 'Windows';
        }
        return 'Unknown';
    }

    function getReferrer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'No referrer';
    }

    function getLanguage()
    {
        return isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'Unknown';
    }

    function getDeviceType()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/mobile/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    function getScreenResolution()
    {
        return isset($_SESSION['screen_resolution']) ? $_SESSION['screen_resolution'] : 'Unknown';
    }

    function getAccessTime()
    {
        return date('Y-m-d H:i:s');
    }

    function getCurrentPage()
    {
        return $_SERVER['REQUEST_URI'];
    }

    function getSessionDuration()
    {
        session_start();
        if (!isset($_SESSION['start_time'])) {
            $_SESSION['start_time'] = time();
        }
        return time() - $_SESSION['start_time'];
    }

    function getHttpHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[$key] = $value;
            }
        }
        return json_encode($headers); // Store as JSON
    }

    function areCookiesEnabled()
    {
        return isset($_COOKIE['cookies_enabled']) ? true : false;
    }

    function getTimezone()
    {
        return isset($_COOKIE['timezone']) ? $_COOKIE['timezone'] : 'Unknown';
    }

    function getProtocol()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'HTTPS' : 'HTTP';
    }

    function getQueryString()
    {
        return $_SERVER['QUERY_STRING'];
    }

    function getGeolocationData($ipAddress)
    {
        // Make a request to ip-api.com
        $response = file_get_contents("http://ip-api.com/json/{$ipAddress}");
        $geoData = json_decode($response, true);

        if ($geoData && $geoData['status'] === 'success') {
            return $geoData;
        }
        return null;  // Return null if the request failed or no data is available
    }

    $sql = "INSERT INTO tbl_visitor_info (
        ip_address, browser_info, operating_system, referrer_url, country, region, city, screen_resolution, language,
        device_type, access_time, current_page, session_duration, http_headers, cookies_enabled, timezone, protocol, query_string
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $conn = get_db_connection();
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Output error if prepare fails
        die("Error preparing statement: " . $conn->error);
    }

    // Collect the data
    $ipAddress = getIpAddress();
    $browserInfo = getBrowserInfo();
    $operatingSystem = getOperatingSystem();
    $referrerUrl = getReferrer();

    $geoData = getGeolocationData($ipAddress);
    $country = isset($geoData['country']) ? $geoData['country'] : 'Unknown';
    $region = isset($geoData['regionName']) ? $geoData['regionName'] : 'Unknown';
    $city = isset($geoData['city']) ? $geoData['city'] : 'Unknown';

    $screenResolution = getScreenResolution();
    $language = getLanguage();
    $deviceType = getDeviceType();
    $accessTime = getAccessTime();
    $currentPage = getCurrentPage();
    $sessionDuration = getSessionDuration();
    $httpHeaders = getHttpHeaders();
    $cookiesEnabled = areCookiesEnabled() ? 1 : 0;
    $timezone = getTimezone();
    $protocol = getProtocol();
    $queryString = getQueryString();

    // Binding parameters using bind_param
    $stmt->bind_param(
        'ssssssssssssssssss',
        $ipAddress,
        $browserInfo,
        $operatingSystem,
        $referrerUrl,
        $country,
        $region,
        $city,
        $screenResolution,
        $language,
        $deviceType,
        $accessTime,
        $currentPage,
        $sessionDuration,
        $httpHeaders,
        $cookiesEnabled,
        $timezone,
        $protocol,
        $queryString
    );

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $stmt->close();
}
?>