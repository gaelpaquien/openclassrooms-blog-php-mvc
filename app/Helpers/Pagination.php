<?php
namespace App\Helpers;

class Pagination {

    public function pagination(int $nbItems, int $perPage) {

        // Define current page
        if (isset($_GET['p']) && !empty($_GET['p'])) {
            $currentPage = (int) strip_tags($_GET['p']);
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

        // Return pages data
        return array([
            'limitFirst' => $limitFirst,
            'perPage' => $perPage,
            'lastPage' => $lastPage,
            'currentPage' => $currentPage
        ]);
    }
    
}
