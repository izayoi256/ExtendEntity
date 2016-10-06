# エンティティ拡張サンプル

## 使い方

下記のブランチをマージした上でEC-CUBEにインストール・有効化して下さい。
https://github.com/EC-CUBE/ec-cube/pull/1817

商品編集ページにアクセスし、ページの上部にその商品の[商品ID][商品名*2回]が表示されていれば正常に動作しています。
(ヘッダーの後ろに表示されるためソース表示や開発ツールで確認して下さい)

## コードの中身

/config.yml のextended_entitiesで、このプラグインで継承するエンティティを列挙します。
本体側で継承する場合、extended_entities.yml.distに列挙して下さい。

```
name: エンティティ拡張サンプル
event: Event
code: ExtendEntity
version: 1.0.0
orm.path:
    - /Resource/doctrine
    - /Resource/doctrine/master
service:
    - ExtendEntityServiceProvider
extended_entities:
    - Eccube\Entity\Product
```

/Resource/doctrine/Plugin.ExtendEntity.Entity.Product.dcm.yml のextended_entityで継承元エンティティを指定し、repositoryClass及びoneToOneを拡張します。

```
Plugin\ExtendEntity\Entity\Product:
     type: entity
     extended_entity: Eccube\Entity\Product
     repositoryClass: Plugin\ExtendEntity\Repository\ProductRepository
     oneToOne:
         Product:
             targetEntity: Eccube\Entity\Product
             joinColumn:
                 name: product_id
                 referencedColumnName: product_id
```

今回は商品エンティティを継承し、Productプロパティを追加しました。
同時に、商品名のgetterをオーバーライドしています。

```
class Product extends \Eccube\Entity\Product
{
    /** @var \Eccube\Entity\Product */
    protected $Product;

    /**
     * @return string
     */
    public function getName()
    {
        return parent::getName() . parent::getName();
    }

    /**
     * @return \Eccube\Entity\Product
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * @param \Eccube\Entity\Product $Product
     * @return Product
     */
    public function setProduct($Product)
    {
        $this->Product = $Product;
        return $this;
    }
}
```

商品編集ページで表示される情報は、拡張した関数から取得した値です。

```

    public function onAdminProductEditInitialize($event)
    {
        $app = $this->app;
        $Product = $event->getArgument('Product');
        if (strlen($Product->getId())) {
            /** @var \Plugin\ExtendEntity\Entity\Product $ExProduct */
            $ExProduct = $app['plugin.extend_entity.repository.product']->find($Product->getId());
            echo $ExProduct->getProduct()->getId();
            echo $ExProduct->getName();
        }
    }
```

## その他

- フィールドを追加するだけでなく、既存フィールドのマッピングを上書きすることも可能です。
上書きといっても、継承元のエンティティには影響を与えません。 

- 本体だけでなく、他プラグインのエンティティを継承することも可能です。
但しプラグインが存在しない場合はエラーが発生するため、必ずプラグインの存在チェックを行なって下さい。

- 継承元の指定で循環するようなエンティティを指定すると無限ループに入ります。
