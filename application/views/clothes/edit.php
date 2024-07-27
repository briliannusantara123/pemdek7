<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php echo form_open('clothes/edit/'.$clothes_item['id']); ?>
    <label for="name">Name</label>
    <input type="text" name="name" value="<?php echo $clothes_item['name']; ?>"><br>

    <label for="size">Size</label>
    <input type="text" name="size" value="<?php echo $clothes_item['size']; ?>"><br>

    <label for="color">Color</label>
    <input type="text" name="color" value="<?php echo $clothes_item['color']; ?>"><br>

    <label for="price">Price</label>
    <input type="text" name="price" value="<?php echo $clothes_item['price']; ?>"><br>

    <input type="submit" name="submit" value="Update">
</form>
