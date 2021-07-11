
<a href="<?=$router->generate('product-list')?>" class="btn btn-success float-right">Retour</a>

        if(!empty($product->getId())){
            echo "<h2>Modifier le produit : " . $product->getName() . "</h2>";
            $route = $router->generate('product-update', ['id' => $product->getId()]);
        }else {
            echo "<h2>Ajouter un produit</h2>";
            $route = $router->generate('product-add');
        }
        ?>
        
        <form action="<?=$route?>" method="POST" class="mt-5">

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie" value="<?=$product->getName();?>">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?=$product->getDescription();?>" 
                aria-describedby="descriptionHelpBlock">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                La description du produit 
            </small>
        </div>

        <div class="form-group">
            <label for="picture">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" value="<?=$product->getPicture();?>" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur 
                <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="form-group">
            <label for="price">Prix</label>
            <input class="form-control" id="price" name="price" placeholder="Prix" value="<?=$product->getPrice();?>" 
                aria-describedby="priceHelpBlock">
            <small id="priceHelpBlock" class="form-text text-muted">
                Le prix du produit 
            </small>
        </div>

        <div class="form-group">
            <label for="rate">Note</label>
            <input type="text" class="form-control" id="rate" name="rate" placeholder="Note" value="<?=$product->getRate();?>" 
                aria-describedby="rateHelpBlock">
            <small id="rateHelpBlock" class="form-text text-muted">
                Le note du produit 
            </small>
        </div>


        <div class="form-group">
            <label for="status">Statut</label>
            <select class="custom-select" id="status" name="status" aria-describedby="statusHelpBlock" value="">
                <option value="2" <?= $product->getStatus() == 2 ? 'selected' : ''?> >Inactif</option>
                <option value="1" <?= $product->getStatus() == 1 ? 'selected' : ''?>>Actif</option>
            </select>
            <small id="statusHelpBlock" class="form-text text-muted">
                Le statut du produit 
            </small>
        </div>

        <div class="form-group">
            <label for="category">Catégorie</label>
            <select class="custom-select" id="category" name="category_id" aria-describedby="categoryHelpBlock" value="">
                
                <?php foreach($categories as $categorie):?>
                    <option value="<?= $categorie->getId();?>" <?= $categorie->getId() == $product->getCategoryId() ? 'selected' : '' ?> ><?= $categorie->getName();?></option>
                <?php endforeach ?>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                La catégorie du produit 
            </small>
        </div>

        <div class="form-group">
            <label for="brand">Marque</label>
            <select  class="custom-select" id="brand" name="brand_id" aria-describedby="brandHelpBlock" value="">
                
            <?php foreach($brands as $brand):?>  
                <option value="<?= $brand->getId();?>" <?= $brand->getId() == $product->getBrandId() ? 'selected' : '' ?> ><?= $brand->getName();?></option>
            <?php endforeach; ?>

            </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                La marque du produit 
            </small>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select class="custom-select" id="type" name="type_id" aria-describedby="typeHelpBlock" value="">
                
             
                <?php foreach($types as $type): ?>
                    <option value="<?= $type->getId();?>" <?= $type->getId() == $product->getTypeId() ? 'selected' : '' ?> ><?= $type->getName();?></option>
                <?php endforeach;?>
            </select>
            <small id="typeHelpBlock" class="form-text text-muted">
                Le type de produit 
            </small>
        </div>
            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>
    