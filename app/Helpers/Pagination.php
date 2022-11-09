<?php
namespace App\Helpers;

class Pagination {

    public function pagination(int $nbItems, int $perPage): array 
    {
        // Define current page
        $superglobal = new superglobal;
        if (isset($superglobal->get_GET()['p']) && !empty($superglobal->get_GET()['p'])) {
            $currentPage = (int) strip_tags($superglobal->get_GET()['p']);
        } else {
            $currentPage = 1;
        }

        // Total page calcul
        $totalPages = intval(ceil($nbItems / $perPage));

        // Check current page
        if ($currentPage > $totalPages || $currentPage < 1) {
            $currentPage = 1;
        }
        if ($currentPage === $totalPages) {
            $lastPage = true;
        } else {
            $lastPage = false;
        }

        // Limit calcul
        $limitFirst = ($currentPage * $perPage) - $perPage;

        // Return data of pages
        return array([
            'limitFirst' => $limitFirst,
            'perPage' => $perPage,
            'lastPage' => $lastPage,
            'currentPage' => $currentPage
        ]);
    }
    
}
