<?php

namespace App\Serializer;


use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class CategoryImageNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';
    private $storage;

    public function __construct(StorageInterface $storageInterface)
    {
        $this->storage = $storageInterface;
    }

    /**
     * Undocumented function
     *
     * @param Category $object
     * @param string|null $format
     * @param array $context
     * @return array|string|integer|float|boolean|\ArrayObject|null
     */
    public function normalize($object, ?string $format = null, array $context = [])
    {
      
        $context[self::ALREADY_CALLED] = true;

        if($object->getImageFile()) {
            $object->setImageUrl($this->storage->resolveUri($object, 'imageFile'));
        }
        

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
   
       
        if (!$data instanceof Category || isset($context[self::ALREADY_CALLED])) {
            return false;
        }
        
        return true;

    }
}