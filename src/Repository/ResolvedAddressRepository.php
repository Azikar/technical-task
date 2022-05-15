<?php

namespace App\Repository;

use App\Entity\ResolvedAddress;
use App\ValueObject\AddressInterface;
use App\ValueObject\Coordinates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Validator\Validation;

/**
 * @method ResolvedAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResolvedAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResolvedAddress[]    findAll()
 * @method ResolvedAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResolvedAddressRepository extends ServiceEntityRepository implements ResolvedAddressRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResolvedAddress::class);
    }

    public function getByAddress(AddressInterface $address): ?ResolvedAddress
    {
        return $this->findOneBy([
            'countryCode' => $address->getCountry(),
            'city' => $address->getCity(),
            'street' => $address->getStreet(),
            'postcode' => $address->getPostcode()
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function saveResolvedAddress(AddressInterface $address, ?Coordinates $coordinates): void
    {
        $resolvedAddress = new ResolvedAddress();
        $resolvedAddress
            ->setCountryCode($address->getCountry())
            ->setCity($address->getCity())
            ->setStreet($address->getStreet())
            ->setPostcode($address->getPostcode());

        if ($coordinates !== null) {
            $resolvedAddress
                ->setLat((string) $coordinates->getLat())
                ->setLng((string) $coordinates->getLng());
        }
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        if (count($validator->validate($resolvedAddress)) > 0) {
            throw new Exception('Invalid data');
        }

        $this->getEntityManager()->persist($resolvedAddress);
        $this->getEntityManager()->flush();
    }
}
