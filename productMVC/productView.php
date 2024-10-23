<?php
class ProductView
{
    public function displayChemises($chemises)
    {
        foreach ($chemises as $chemise) {
            echo "<div class='chemise' id='{$chemise['ID']}'><img src='images/tshirt{$chemise['ID']}.webp' alt='tshirt{$chemise['ID']}'><h3>{$chemise['Nom']}</h3><div class='prix'>$ {$chemise['Prix']}</div></div>";
        }
    }
    public function displayCravattes($cravates)
    {
        foreach ($cravates as $cravate) {
            echo "<div class='cravatte' id='{$cravate['ID']}' href='produit.php?id=<?= {$cravates['ID']} ?>'><img src='images/tie{$cravate['ID']}.webp' alt='tie{$cravate['ID']}'><h3>{$cravate['Nom']}</h3><div class='prix'>$ {$cravate['Prix']}</div></div>";
        }
    }
    public function displayProduits($produits){
        foreach ($produits as $produit):
            echo "
             <a href='produit.php?id={$produit['id']}' class='product' id='{$produit['id']}'>
                <div class='productBox' id='{$produit['id']}'>
                    <img src='../images/{$produit['image']}' alt='produit{$produit['nom']}'>
                    <h3>{$produit['nom']}</h3>
                    <div class='prix'>$ {$produit['prix']}</div>
                </div>
             </a>";
        endforeach;
    }
}
