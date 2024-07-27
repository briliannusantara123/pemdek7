<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php echo form_open('clothes/create'); ?>
    <label for="name">Name</label>
    <input type="text" name="name"><br>

    <label for="size">Size</label>
    <input type="text" name="size"><br>

    <label for="color">Color</label>
    <input type="text" name="color"><br>

    <label for="price">Price</label>
    <input type="text" name="price"><br>

    <input type="submit" name="submit" value="Create">
</form>
