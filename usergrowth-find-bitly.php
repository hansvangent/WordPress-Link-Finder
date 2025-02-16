<?php
class FindBitlyLinks {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_submenu_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_find_bitly_links', [$this, 'find_bitly_links']);
    }

    public function add_submenu_page() {
        add_submenu_page(
            'tools.php',
            'Find and Replace Bitly Links',
            'Find Bitly Links',
            'edit_posts',
            'find-bitly-links',
            [$this, 'render_page']
        );
    }

    public function render_page() {
        ?>
        <div class="wrap">
            <h1>Find Bitly Links</h1>
            <button id="find-bitly-links" class="button button-primary">Find Bitly Links</button>
            <div id="results-table" style="margin-top: 20px;"></div>
        </div>
        <script>
        jQuery(document).ready(function($) {
            $('#find-bitly-links').on('click', function() {
                const button = $(this);
                button.prop('disabled', true).text('Searching...');
                
                $.ajax({
                    url: findBitlyLinks.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'find_bitly_links',
                        _ajax_nonce: findBitlyLinks.nonce
                    },
                    success: function(response) {
                        button.prop('disabled', false).text('Find Bitly Links');
                        
                        if (response.success && response.data.length > 0) {
                            let table = '<table class="wp-list-table widefat fixed striped">';
                            table += '<thead><tr><th>Post Title</th><th>Status</th><th>Context</th><th>Bitly Link</th><th>Action</th></tr></thead><tbody>';
                            
                            response.data.forEach(function(item) {
                                table += `<tr>
                                    <td>${item.post_title}</td>
                                    <td>${item.post_status}</td>
                                    <td>${item.context}</td>
                                    <td>${item.bitly_link}</td>
                                    <td><a href="/wp-admin/post.php?post=${item.post_id}&action=edit" class="button">Edit</a></td>
                                </tr>`;
                            });
                            
                            table += '</tbody></table>';
                            $('#results-table').html(table);
                        } else {
                            $('#results-table').html('<p>No Bitly links found.</p>');
                        }
                    },
                    error: function() {
                        button.prop('disabled', false).text('Find Bitly Links');
                        $('#results-table').html('<p>Error occurred while searching.</p>');
                    }
                });
            });
        });
        </script>
        <?php
    }

    public function enqueue_scripts($hook) {
        if ($hook !== 'tools_page_find-bitly-links') return;

        wp_localize_script('jquery', 'findBitlyLinks', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('find-bitly-links'),
        ]);
    }

    public function find_bitly_links() {
        check_ajax_referer('find-bitly-links');

        $post_types = get_post_types(['public' => true]);
        $posts = get_posts([
            'post_type' => $post_types,
            'posts_per_page' => -1,
            'post_status' => ['publish', 'draft', 'pending', 'private', 'trash'],
        ]);

        $results = [];
        $bitly_patterns = [
            'bit.ly/',
            'bitly.com/',
            'j.mp/',
        ];

        foreach ($posts as $post) {
            foreach ($bitly_patterns as $pattern) {
                if (strpos($post->post_content, $pattern) !== false) {
                    preg_match_all('/(https?:\/\/)?(bit\.ly|bitly\.com|j\.mp)\/\w+/', $post->post_content, $matches, PREG_OFFSET_CAPTURE);
                    
                    if (!empty($matches[0])) {
                        foreach ($matches[0] as $match) {
                            $bitly_url = $match[0];
                            $position = $match[1];
                            
                            // Get surrounding context (100 chars before and after)
                            $start = max(0, $position - 100);
                            $length = strlen($bitly_url) + 200;
                            $context = substr($post->post_content, $start, $length);
                            
                            // Highlight the link in the context
                            $context = esc_html($context);
                            $context = str_replace($bitly_url, "<strong>$bitly_url</strong>", $context);
                            
                            // Add ellipsis if we're not at the start/end
                            if ($start > 0) {
                                $context = "..." . $context;
                            }
                            if ($start + $length < strlen($post->post_content)) {
                                $context .= "...";
                            }

                            $results[] = [
                                'post_title' => $post->post_title,
                                'post_id' => $post->ID,
                                'post_status' => $post->post_status,
                                'bitly_link' => $bitly_url,
                                'context' => $context,
                            ];
                        }
                    }
                }
            }
        }

        wp_send_json_success($results);
    }
}