<?php

namespace App\Components;

use Phalcon\Di\Injectable;

/**
 * helper class for hitting the api and getting response
 */
class SearchComponent extends Injectable
{
    /**
     * returns whatever the response of the passed url
     *
     * @param [string] $q
     * @return ARRAY
     */
    public function search($q)
    {
        if ($this->cache->has($q)) {
            return $this->cache->get($q);
        }
        $q = implode('+', explode(' ', $q));
        $url = "https://openlibrary.org/search.json?q={$q}&mode=ebooks&has_fulltext=true";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        $response = json_decode($resp, true);

        $this->cache->set($q, $response);

        return $response;
    }
    /**
     * return an image path
     *
     * @param [string] $lending_edition_s
     * @param [string] $size
     * @return string
     */
    public function getImage($lending_edition_s, $size)
    {
        $image = "https://covers.openlibrary.org/b/olid/{$lending_edition_s}-{$size}.jpg";
        return $image;
    }
    public function getBookById($q)
    {
        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:{$q}&jscmd=details&format=json";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $resp = curl_exec($ch);

        $response = json_decode($resp, true);

        return $response;
    }
}
