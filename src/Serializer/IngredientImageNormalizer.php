<?php

namespace App\Serializer;

use App\Entity\Ingredient;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class IngredientImageNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';
    private $storage;
    private $em;

    public function __construct(StorageInterface $storageInterface, EntityManagerInterface $em)
    {
        $this->storage = $storageInterface;
        $this->em = $em;
    }

    /**
     * Undocumented function
     *
     * @param Ingredient $object
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
   
       
        if (!$data instanceof Ingredient || isset($context[self::ALREADY_CALLED])) {
            return false;
        }
        
        return true;

    }
}