<?php
class Admin_Form
{
    const ID = 'config-seo';

    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_pages'), 1);
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('wp_ajax_save_category', array($this, 'save_category'));
        add_action('wp_ajax_save_general', array($this, 'save_general'));
        add_action('wp_ajax_save_trending', array($this, 'save_trending'));
        add_action('wp_ajax_delete_trending', array($this, 'delete_trending'));
    }

    public function get_id()
    {
        return self::ID;
    }

    public function admin_enqueue_scripts($hook_suffix)
    {
        if (strpos($hook_suffix, $this->get_id()) === false) {
            return;
        }

        wp_enqueue_media();

        wp_enqueue_style('config-admin-form-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', BINHCHAY_ADMIN_VERSION);
        wp_enqueue_script(
            'config-admin-form-bs',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            BINHCHAY_ADMIN_VERSION,
            true
        );

        wp_enqueue_script(
            'config-admin-form-bs',
            'https://code.jquery.com/jquery-3.7.1.slim.js'
        );

        echo '
        <style>
            .button-submit {
                border: 1px solid black !important;
            }

            .post-title {
                font-weight: bold !important;
                font-size: 19px !important;
            }

            #alert-post {
                display: none;
            }
        </style>';
    }

    function add_menu_pages()
    {
        add_menu_page('For SEO', 'For SEO', 10, $this->get_id() . '_general', array(&$this, 'load_view_general'), plugins_url('binhchay/images/icon.png'));
        add_submenu_page($this->get_id() . '_general', 'General', 'General', 10,  $this->get_id() . '_general', array(&$this, 'load_view_general'));
        add_submenu_page($this->get_id() . '_general', 'Set Category', 'Set Category', 10,  $this->get_id() . '_set_category', array(&$this, 'load_view_set_category'));
        add_submenu_page($this->get_id() . '_general', 'Trending Search', 'Trending Search', 10, $this->get_id() . '_trending', array(&$this, 'load_view_trending'));
    }

    public function load_view_general()
    {
        $h1Homepage = get_option('h1_homepage');
        $aboutUsSeo = get_option('about_us_seo');
        $nonce = wp_create_nonce("get_game_nonce");
        $link = admin_url('admin-ajax.php');

        echo '<script>
            let dataGeneral = {};
        </script>';
        echo '<div class="container mt-5">';
        echo "<div class='alert' role='alert' id='alert-post'></div>";
        echo '<h3>Setup H1 in homepage</h3>';
        if ($h1Homepage) {
            echo '<input class="form-control" value="' . $h1Homepage . '" id="h1-home-page">';
        } else {
            echo '<input class="form-control" id="h1-home-page">';
        }
        echo '<h3 class="mt-4">Setup About us</h3>';
        if ($aboutUsSeo) {
            echo '<textarea class="form-control" id="about-us">' . $aboutUsSeo . '</textarea>';
        } else {
            echo '<textarea class="form-control" id="about-us"></textarea>';
        }
        echo '<button class="btn btn-success mt-4" type="button" id="save-general">Save</button>';
        echo '</div>';

        echo '<script>
        jQuery(document).ready( function() {
            jQuery("#save-general").on("click", function(e) {
                e.preventDefault();
                dataGeneral.h1 = jQuery("#h1-home-page").val();
                dataGeneral.about_us = jQuery("#about-us").val();
        
                jQuery.post("' . $link . '", 
                    {
                        "action": "save_general",
                        "data": dataGeneral,
                        "nonce": "' . $nonce . '"
                    }, 
                    function(response) {
                        if(response == "failed") {
                            let alert = document.getElementById("alert-post");
                            if(alert.classList.contains("alert-success")) {
                                alert.classList.remove("alert-success");
                            }
                            alert.classList.add("alert-danger");
                            alert.style.display = "block";
                            alert.innerHTML = "Save failed! H1 or About us is empty.";
                        } else {
                            let alert = document.getElementById("alert-post");
                            if(alert.classList.contains("alert-danger")) {
                                alert.classList.remove("alert-danger");
                            }
                            alert.classList.add("alert-success");
                            alert.style.display = "block";
                            alert.innerHTML = "Save successfully!";
                        }
                    }
                );
            });
        });
        </script>';
    }

    public function load_view_set_category()
    {
        $categories = get_categories();
        $custom_categories = $this->getCustomCategory();
        $nonce = wp_create_nonce("get_game_nonce");
        $link = admin_url('admin-ajax.php');

        echo '<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>';
        echo '<script>
            let listCategory = ' . json_encode($categories) . ';
            let array = Object.keys(listCategory);
            let dataCategory = {};
        </script>';
        echo '<div class="container mt-5">';
        echo "<div class='alert' role='alert' id='alert-post'></div>";
        echo '<ul class="list-group ul-post">';

        foreach ($categories as $category) {
            foreach ($custom_categories as $cate) {
                if ($category->term_id == $cate->category_id) {
                    $category->icon = $cate->icon;
                    $category->content = $cate->content;
                }
            }

            echo '<li class="list-group-item item-post">
                <div>
                <span class="post-title">' . $category->name . '</span>
                <span><img src="' . $category->icon . '" id="wk-media-img-' . $this->slugify($category->name) . '" width="30"></span>
                <span><input id="wk-media-url-' . $this->slugify($category->name) . '" type="hidden"/></span>
                <span class="button media_upload_button mb-2" id="' . esc_attr('icon') . '-media-' . $this->slugify($category->name) . '">' . esc_html__('Upload', 'redux-framework') . '</span>
                </div>
                <span style="margin-top: 10px;">
                <textarea name="' . $category->slug . '">' . $category->content . '</textarea>
                </span>
                <script>
                let area_' . str_replace('-', '_', $category->slug) . ' = CKEDITOR.replace("' . $category->slug . '");
                dataCategory.' . str_replace('-', '_', $category->slug) . ' = {
                    content: "",
                    icon: "",
                };
                area_' . str_replace('-', '_', $category->slug) . '.on("change", function(evt) {
                    dataCategory.' . str_replace('-', '_', $category->slug) . '.content = String(evt.editor.getData());
                });';

            if (isset($category->icon)) {
                echo 'dataCategory.' . str_replace('-', '_', $category->slug) . '.icon = "' . $category->icon . '";';
            }

            if (isset($category->content)) {
                echo 'dataCategory.' . str_replace('-', '_', $category->slug) . '.content = `' . html_entity_decode($category->content) . '`;';
            }

            echo 'jQuery("#icon-media-" + "' . $this->slugify($category->name) . '").on("click", function(e) {
                    e.preventDefault();
                    let wkMedia;
                    let splice = this.id.split("-");
                    let idInput = "#wk-media-url-" + splice[2];
                    let idImg = "#wk-media-img-" + splice[2];

                    if (wkMedia) {
                        wkMedia.open();
                        return;
                    }
    
                    wkMedia = wp.media.frames.file_frame = wp.media({
                        title: "Select media",
                        button: {
                            text: "Select media"
                        }, multiple: false });

                    wkMedia.on("select", function() {
                        var attachment = wkMedia.state().get("selection").first().toJSON();
                        jQuery(idInput).val(attachment.url);
                        jQuery(idImg).attr("src", attachment.url);
                        dataCategory.' . str_replace('-', '_', $category->slug) . '.icon = jQuery(idImg).attr("src");
                    });
    
                    wkMedia.open();
                });
                </script>
                </li>';
        }

        echo '</ul>';
        echo '<button class="btn btn-success mt-4" type="button" id="save-category">Save</button>';
        echo '</div>';

        echo '<script>
        jQuery(document).ready( function() {
            jQuery("#save-category").on("click", function(e) {
                e.preventDefault();
        
                jQuery.post("' . $link . '", 
                    {
                        "action": "save_category",
                        "data": dataCategory,
                        "nonce": "' . $nonce . '"
                    }, 
                    function(response) {
                        document.documentElement.scrollTop = 0;
                        setInterval(function () {
                            let alert = document.getElementById("alert-post");
                            alert.classList.add("alert-success");
                            alert.style.display = "block";
                            alert.innerHTML = "Save successfully!";
                        }, 3000);
                    }
                );
            });
        });
        </script>';
    }

    public function load_view_trending()
    {
        $listTrending = $this->getUrlTrending();
        $count = 1;
        $classText = "'text-danger'";
        $functionDelete = "'deleteTrending(this.id)'";
        $idText = "id='td-";
        $nonce = wp_create_nonce("get_game_nonce");
        $link = admin_url('admin-ajax.php');

        echo '
        <style>
            .form-control {
                width: 49% !important;
            }

            a:hover {
                cursor: pointer;
            }
        </style>';

        echo '<div class="container mt-5">';
        echo '<label for="basic-url" class="form-label">Add trending search</label>
        <div class="form-group mb-3 d-flex justify-content-between">
            <input type="text" class="form-control" placeholder="Enter title" id="title-input">
            <input type="text" class="form-control" placeholder="Enter link" id="link-input">
        </div>
        <div><button class="btn btn-success" id="store-trending" onclick="saveTrending()">Save</button></div>';
        echo '
        <table class="table" id="table-trending">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Link</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($listTrending as $trending) {
            echo    '<tr id="td-' . $trending->id . '">
                    <th scope="row">' . $count . '</th>
                    <td>' . $trending->title . '</td>
                    <td>' . $trending->url . '</td>
                    <td><a class="' . 'text-danger' . '" id="' . $trending->id . '" onclick="' . 'deleteTrending(this.id)' . '">x</a></td>
                    </tr>';

            $count++;
        }

        echo    '</tbody>
        </table>';
        echo '</div>';

        echo '<script>
            function saveTrending() {

                let title = jQuery("#title-input").val();
                let url = jQuery("#link-input").val();
                let data = {"title": title, "url": url};

                jQuery.post("' . $link . '", 
                    {
                        "action": "save_trending",
                        "data": data,
                        "nonce": "' . $nonce . '"
                    }, 
                    function(response) {
                        let rowCount = jQuery("#table-trending tr").length;
                        let currentId = 0;
                        if(rowCount == 1) {
                            currentId = 1;
                        } else {
                            let lastId = jQuery("#table-trending tr:last").attr("id");
                            let split = lastId.split("-");
                            currentId = parseInt(split[1]) + 1;
                        }
                    
                        let newTr = "<tr ' . $idText . '" + currentId + "' . "'" . '><th>" + rowCount + "</th><td>" + title + "</td><td>" + url + "</td><td><a id=" + currentId + " class=' . $classText . ' onclick=' . $functionDelete . '>x</a></td></tr>";
                        jQuery("#table-trending tbody").append(newTr);
                    }
                );
            }

            function deleteTrending(id) {
                let data = {"id": id};
                jQuery.post("' . $link . '", 
                    {
                        "action": "delete_trending",
                        "data": data,
                        "nonce": "' . $nonce . '"
                    }, 
                    function(response) {
                        let idTr = "#td-" + id;
                        let deleteTr = jQuery(idTr);
                        deleteTr.remove();
                    }
                );
            }
        </script>';
    }

    public function getUrlTrending()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_trending_search");

        return $result;
    }

    public function getCustomCategory()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_category_custom");

        return $result;
    }

    public function save_category()
    {
        if (!wp_verify_nonce($_REQUEST['nonce'], "get_game_nonce")) {
            exit("Please don't fucking hack this API");
        }

        global $wpdb;
        $data = $_REQUEST['data'];

        foreach ($data as $key => $val) {
            $slug = str_replace("_", "-", $key);
            $getCategory = get_category_by_slug($slug);
            $queryGet = "SELECT * FROM " . $wpdb->prefix . 'category_custom WHERE category_id = "' . $getCategory->term_id . '"';
            $result = $wpdb->query($queryGet);
            if ($result == 0) {
                $query = 'INSERT INTO ' . $wpdb->prefix . 'category_custom (`category_id`, `content`, `icon`) VALUES ';
                $query .= ' ("' . $getCategory->term_id . '", "' . htmlentities($val['content']) . '", "' . $val['icon'] . '")';
            } else {
                $query = 'UPDATE ' . $wpdb->prefix . 'category_custom';
                $query .= ' SET `content` = "' . htmlentities($val['content']) . '", `icon` = "' . $val['icon'] . '" WHERE category_id = "' . $getCategory->term_id . '"';
            }

            $wpdb->query($query);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result);
            echo $result;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function save_general()
    {
        if (!wp_verify_nonce($_REQUEST['nonce'], "get_game_nonce")) {
            exit("Please don't fucking hack this API");
        }

        $data = $_REQUEST['data'];
        if (empty($data['h1']) || empty($data['about_us'])) {
            echo 'failed';
            die;
        }

        $h1Homepage = get_option('h1_homepage');
        $aboutUsSeo = get_option('about_us_seo');

        if ($h1Homepage == false) {
            add_option('h1_homepage', $data['h1']);
        } else {
            update_option('h1_homepage', $data['h1']);
        }

        if ($aboutUsSeo == false) {
            add_option('about_us_seo', $data['about_us']);
        } else {
            update_option('about_us_seo', $data['about_us']);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo 'success';
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function save_trending()
    {
        if (!wp_verify_nonce($_REQUEST['nonce'], "get_game_nonce")) {
            exit("Please don't fucking hack this API");
        }

        global $wpdb;
        $data = $_REQUEST['data'];

        if (empty($data['title']) || empty($data['url'])) {
            die;
        }

        $table = $wpdb->prefix . 'trending_search';
        $wpdb->insert($table, array(
            'title' => $data['title'],
            'url' => $data['url'],
        ));

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result);
            echo $result;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function delete_trending()
    {
        if (!wp_verify_nonce($_REQUEST['nonce'], "get_game_nonce")) {
            exit("Please don't fucking hack this API");
        }

        global $wpdb;
        $data = $_REQUEST['data'];
        if (empty($data['id'])) {
            die;
        }

        $table = $wpdb->prefix . 'trending_search';
        $wpdb->delete($table, array(
            'id' => $data['id'],
        ));

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result);
            echo $result;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
