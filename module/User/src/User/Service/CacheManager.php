<?php
namespace User\Service;



class CacheManager extends \HtProfileImage\Service\CacheManager
{
    
    public function createCache(UserInterface $user, $filter, ImageInterface $image)
    {
        $this->cacheManager->createCache(
            'user/' . $user->getId(),
            $filter,
            $image,
            $this->storageModel->getUserImageExtension()
        );
    }
    
}

