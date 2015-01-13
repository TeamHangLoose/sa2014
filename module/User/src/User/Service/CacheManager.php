<?php
namespace User\Service;

use ZfcUser\Entity\UserInterface;
use Imagine\Image\ImageInterface;
use  HtImgModule\Service\CacheManagerInterface as HtImgCacheManagerInterface;
use HtProfileImage\Model\StorageModelInterface;

class CacheManager implements \HtProfileImage\Service\CacheManagerInterface
{
    /**
     * @var HtImgCacheManagerInterface
     */
    protected $cacheManager;

    /**
     * @var StorageModelInterface
     */
    protected $storageModel;
    
    protected  $salt = '())(U)W(HNIUBSXIZUw3uhiw3uhr9pHè=)!E=)U=)eudowu8eh9w89d8'; 



    /**
     * Constructor
     *
     * @param HtImgCacheManagerInterface $cacheManager
     * @param StorageModelInterface      $storageModel
     */
    public function __construct(HtImgCacheManagerInterface $cacheManager, StorageModelInterface $storageModel)
    {
        $this->cacheManager = $cacheManager;
        $this->storageModel = $storageModel;
    }

    /**
     * {@inheritDoc}
     */
    public function cacheExists(UserInterface $user, $filter)
    {
        
        return $this->cacheManager->cacheExists(
            'user/' . crc32($this->salt . strval($user->getId())). crc32($this->salt . strval($this->salt)),
            $filter,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheUrl(UserInterface $user, $filter)
    {
        return $this->cacheManager->getCacheUrl(
            'user/' . crc32($this->salt . strval($user->getId())). crc32($this->salt . strval($this->salt)),
            $filter,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getCachePath(UserInterface $user, $filter)
    {
        return $this->cacheManager->getCachePath(
            'user/' . crc32($this->salt . strval($user->getId())). crc32($this->salt . strval($this->salt)),
            $filter,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function createCache(UserInterface $user, $filter, ImageInterface $image)
    {
        $this->cacheManager->createCache(
            'user/' . crc32($this->salt . strval($user->getId())). crc32($this->salt . strval($this->salt)),
            $filter,
            $image,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function deleteCache(UserInterface $user, $filter)
    {
        $cachePath = $this->getCachePath($user, $filter);

        return is_readable($cachePath) ? unlink($cachePath) : false;
    }
    
    
}
