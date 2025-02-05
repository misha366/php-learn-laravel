<?php

namespace App\Services;

use App\Repository\Meta\MetaRepositoryInterface;

class MetaService
{
    private MetaRepositoryInterface $metaRepository;

    public function __construct(MetaRepositoryInterface $metaRepository)
    {
        $this->metaRepository = $metaRepository;
    }

    public function getCategoriesAndTags() : array {
        return $this->metaRepository->getCategoriesAndTags();
    }

}
