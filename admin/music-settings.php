<div class="wrap">
    <h1>Music Settings</h1>
    <?php 
    $message = "";
    if(isset($_POST['submit']) && $_POST['submit'] == 'Save Changes'){

        $currency = $_POST['currency'];

        $musics_per_page = $_POST['musics_per_page'];

        update_option('wp_music_currency', $currency);

        update_option('wp_music_music_per_page', $musics_per_page);

        $message = '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"><p><strong>Settings saved.</strong></p></div>';

    }

    $currency = get_option('wp_music_currency');
    $musics_per_page = get_option('wp_music_music_per_page');

    if($message){
        echo $message;
    }

    ?>
    <form action="" method="post">

        <table class="form-table">

            <tbody>

                <tr>
                    <th>Currency</th>
                    <td><input type="text" value="<?php echo $currency ?>" name="currency" /></td>
                </tr>

                <tr>
                    <th>Musics Display Per Page</th>
                    <td><input type="number" value="<?php echo $musics_per_page ?>" name="musics_per_page" /></td>
                </tr>

            </tbody>

        </table>

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

    </form>
</div>