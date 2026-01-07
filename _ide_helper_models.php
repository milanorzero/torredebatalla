<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string|null $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $buy_order
 * @property string|null $webpay_token
 * @property int|null $user_id
 * @property int $is_guest
 * @property string $email
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono
 * @property string $documento
 * @property string $tipo_envio
 * @property string|null $comuna
 * @property string|null $calle
 * @property string|null $numero
 * @property string|null $extra
 * @property string|null $codigo_postal
 * @property string|null $local_retiro
 * @property string|null $metodo_pago
 * @property string $estado_pago
 * @property string|null $payment_proof
 * @property int $subtotal
 * @property int $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereApellidos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereBuyOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCodigoPostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereComuna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereEstadoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereIsGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereLocalRetiro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNombres($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentProof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTipoEnvio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereWebpayToken($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $price
 * @property int $quantity
 * @property int $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereUpdatedAt($value)
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $channel
 * @property int $points
 * @property string $reason
 * @property int|null $reference_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PointTransaction whereUserId($value)
 */
	class PointTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $product_title
 * @property string|null $product_description
 * @property int|null $product_quantity
 * @property string $sale_channel
 * @property int|null $product_price
 * @property int|null $offer_price
 * @property int $is_on_offer
 * @property string|null $product_image
 * @property string|null $product_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $final_price
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsOnOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSaleChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string|null $session_id
 * @property int $product_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCart whereUserId($value)
 */
	class ProductCart extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int $points_balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $user_type
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PointTransaction> $pointTransactions
 * @property-read int|null $point_transactions_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePointsBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserType($value)
 */
	class User extends \Eloquent {}
}

