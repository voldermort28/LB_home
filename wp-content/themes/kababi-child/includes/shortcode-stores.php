<?php
/**
 * Laboon Store Locator Shortcode
 * Renders the custom Store Locator Layout A
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function laboon_store_locator_shortcode() {
    // Store Data Array
    $stores = [
        'quan-3' => [
            'id' => 'quan-3',
            'tab_label' => 'Quận 3',
            'name' => '92 CAO THẮNG',
            'address' => '92B Cao Thắng, Phường 4, Quận 3, TP. Hồ Chí Minh',
            'hours' => '8:00 - 22:30',
            'hotline' => '0962463086',
            'image' => 'https://laboon.vn/wp-content/uploads/2025/06/SHOP3_Artboard-1@2x_1.webp',
            'links' => [
                'grab' => '#',
                'shopee' => '#',
                'be' => '#',
                'website' => 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=117986'
            ]
        ],
        'quan-4' => [
            'id' => 'quan-4',
            'tab_label' => 'Quận 4',
            'name' => '246 KHÁNH HỘI',
            'address' => '246 Khánh Hội, Phường 6, Quận 4, TP. Hồ Chí Minh',
            'hours' => '8:00 - 22:30',
            'hotline' => '0962463086',
            'image' => 'https://laboon.vn/wp-content/uploads/2025/06/SHOP1_Artboard-1@2x_1.webp',
            'links' => [
                'grab' => '#',
                'shopee' => '#',
                'be' => '#',
                'website' => 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=73661'
            ]
        ],
        'quan-7' => [
            'id' => 'quan-7',
            'tab_label' => 'Quận 7',
            'name' => '79 ĐƯỜNG SỐ 17',
            'address' => '79 đường 17, Tân Quy, Quận 7, TP. Hồ Chí Minh',
            'hours' => '8:00 - 22:30',
            'hotline' => '0962463086',
            'image' => 'https://laboon.vn/wp-content/uploads/2025/06/SHOP2_Artboard-1@2x_1.webp',
            'links' => [
                'grab' => '#',
                'shopee' => '#',
                'be' => '#',
                'website' => 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=93349'
            ]
        ]
    ];

    ob_start();
    ?>
    <div class="laboon-store-locator-wrapper">
        <div class="lsl-container">
            <!-- Left Column: Contact -->
            <div class="lsl-contact-col">
                <div class="lsl-contact-card">
                    <h2 class="lsl-heading">Liên Hệ</h2>
                    <p class="lsl-desc">Bạn có thể liên hệ với Laboon qua các kênh sau:</p>
                    
                    <div class="lsl-contact-item">
                        <div class="lsl-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="lsl-info">
                            <span class="lsl-label">Email</span>
                            <a href="mailto:contact@laboon.vn" class="lsl-value">contact@laboon.vn</a>
                        </div>
                    </div>

                    <div class="lsl-contact-item">
                        <div class="lsl-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="lsl-info">
                            <span class="lsl-label">Điện thoại</span>
                            <a href="tel:0962463086" class="lsl-value">0962463086</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Stores -->
            <div class="lsl-stores-col">
                <h2 class="lsl-heading">Hệ Thống Cửa Hàng</h2>
                <div class="lsl-stores-layout">
                    
                    <!-- Tabs -->
                    <div class="lsl-tabs-nav">
                        <?php $first = true; foreach ($stores as $store) : ?>
                            <button class="lsl-tab-btn <?php echo $first ? 'active' : ''; ?>" data-target="<?php echo esc_attr($store['id']); ?>">
                                <?php echo esc_html($store['tab_label']); ?>
                            </button>
                        <?php $first = false; endforeach; ?>
                    </div>

                    <!-- Tab Contents -->
                    <div class="lsl-tabs-content">
                        <?php $first = true; foreach ($stores as $store) : ?>
                            <div class="lsl-tab-pane <?php echo $first ? 'active' : ''; ?>" id="lsl-pane-<?php echo esc_attr($store['id']); ?>">
                                <div class="lsl-store-card">
                                    <div class="lsl-store-image">
                                        <img src="<?php echo esc_url($store['image']); ?>" alt="<?php echo esc_attr($store['name']); ?>">
                                    </div>
                                    <div class="lsl-store-details">
                                        <h3 class="lsl-store-name"><?php echo esc_html($store['name']); ?></h3>
                                        
                                        <ul class="lsl-store-meta">
                                            <li><i class="fas fa-map-marker-alt"></i> <strong>Địa chỉ:</strong> <span><?php echo esc_html($store['address']); ?></span></li>
                                            <li><i class="far fa-clock"></i> <strong>Giờ mở cửa:</strong> <span><?php echo esc_html($store['hours']); ?></span></li>
                                            <li><i class="fas fa-phone-alt"></i> <strong>Hotline:</strong> <span><?php echo esc_html($store['hotline']); ?></span></li>
                                        </ul>
                                        
                                        <div class="lsl-store-apps">
                                            <p class="lsl-apps-title"><i class="fas fa-shopping-cart"></i> Mua hàng tại các kênh:</p>
                                            <div class="lsl-badges">
                                                <a href="<?php echo esc_url($store['links']['grab']); ?>" class="lsl-badge badge-grab" target="_blank" rel="nofollow">Grab</a>
                                                <a href="<?php echo esc_url($store['links']['shopee']); ?>" class="lsl-badge badge-shopee" target="_blank" rel="nofollow">Shopee</a>
                                                <a href="<?php echo esc_url($store['links']['be']); ?>" class="lsl-badge badge-be" target="_blank" rel="nofollow">Be</a>
                                                <a href="<?php echo esc_url($store['links']['website']); ?>" class="lsl-badge badge-web" target="_blank" rel="nofollow">Website</a>
                                            </div>
                                        </div>
                                        
                                        <a href="https://maps.google.com/?q=<?php echo urlencode($store['address']); ?>" class="lsl-map-btn" target="_blank" rel="nofollow">Xem trên bản đồ</a>
                                    </div>
                                </div>
                            </div>
                        <?php $first = false; endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabBtns = document.querySelectorAll('.lsl-tab-btn');
        var tabPanes = document.querySelectorAll('.lsl-tab-pane');

        tabBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active classes
                tabBtns.forEach(function(b) { b.classList.remove('active'); });
                tabPanes.forEach(function(p) { p.classList.remove('active'); });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show target pane
                var targetId = 'lsl-pane-' + this.getAttribute('data-target');
                var targetPane = document.getElementById(targetId);
                if(targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('laboon_stores', 'laboon_store_locator_shortcode');
