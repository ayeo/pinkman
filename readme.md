# Didler is safe serialization/deserialization utilility with dead simple config

Didler is super happy to convert any object to an array for you. It also here to reconsistute the object from pure array
data. At my company we happily use Didler to help us store our aggregates into the database. In case you struggle with 
CQRS approachat your side you may find him usefull as well. Think of Didler as of your personal laboratory assistant.
He can't wait to help you rule the world tonignt.

## Motivation

Build-in php serialize/unserialize functions works fine until you are not about to change your objects. Then it becomes
impossibne to unserialize prevoisly serialized object. I have found few similar tools on github but wasn't happy with
any mainly because of hard config.

## Core features

- working with privete/proteced properties
- handling nested objects
- handling recurrent nesting
- handling nested arrays/collectoins
 
## The simplest possible scenario example

### Serialization 

Consider the simple flat object to get the point:

```php
class Address
{
    private $street;
    private $buildingNumber;
    private $apartamentNumber;
    private $postalCode;
    private $town;
    
    public function __construct(
        string $street,
        string $buildingNumber,
        string $apartamentNumver,
        string $postalCode,
        string $town,
        string $countryCode
    ) {
        //...
    }
}
```

Converting to an array is straitforward

```php
$address = new Address('Thomas Edisson Av', '34a', '11', 'NG10-32Q', 'Nottingham', 'UK');
$didler = new Didler()
$pureData = $didler->distill($address);
```

Data array looks like this:
```php
$pureData = [
    'street' => 'Thomas Edisson Av',
    'buildingNumber' => '34a',
    'apartamentNumber' => '11',
    'postalCode' => 'NG10-34Q',
    'town' => 'Nottingham',
    'countryCode' => 'UK'
];
```
It is nothing more than mapping object structure to an array. But is start shinning with more complex structures.

### Deserialization

As you have probably noticed the output data is an array consisting of raw data. To reconstitute living object you
need to provide adequate config. In our simple scenario looks like this:
```php
$config = [
    'class' => Address::class
];
$object = $didler->hydrate($pureData, $config);
```

More elaborate and complex examples are comming your way

