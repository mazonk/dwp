<form action="<?php echo $baseRoute; ?>upload-image" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="upload_path" value="<?php echo htmlspecialchars($uploadPath); ?>">
    <label for="image">Select an image:</label>
    <input type="file" name="image" id="image" accept="image/*" required>
    <button type="submit">Upload Image</button>
</form>
