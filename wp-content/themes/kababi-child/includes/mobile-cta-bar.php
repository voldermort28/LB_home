<?php
/**
 * Mobile Sticky Conversion Bar & Quick Order Drawer
 * Strategy 04: Mobile CRO Optimization for Laboon
 * Updated: 2-step navigation (Channel selection -> Specific Store Branch selection)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_footer', 'laboon_render_mobile_cta_bar', 99 );
function laboon_render_mobile_cta_bar() {
    // Only display on front-end
    if ( is_admin() ) {
        return;
    }
    ?>
    <!-- Laboon Mobile Sticky CTA Bar -->
    <div id="laboon-mobile-bar" class="laboon-mobile-bar" aria-label="Điều hướng đặt món nhanh">
        <!-- 1. Store Location -->
        <a href="https://laboon.vn/cua-hang/" class="lmb-item lmb-store" title="Xem danh sách chi nhánh">
            <span class="lmb-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </span>
            <span class="lmb-text">Chi Nhánh</span>
        </a>

        <!-- 2. Main Order Button (Hero CTA) -->
        <button type="button" id="lmb-open-modal" class="lmb-hero-btn" aria-label="Mở menu đặt món">
            <span class="lmb-hero-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </span>
            <span class="lmb-hero-text">ĐẶT MÓN NGAY</span>
            <span class="lmb-pulse"></span>
        </button>

        <!-- 3. Hotline Call Button -->
        <a href="tel:0962463086" class="lmb-item lmb-call" title="Gọi hotline Laboon">
            <span class="lmb-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
            </span>
            <span class="lmb-text">Hotline</span>
        </a>
    </div>

    <!-- Quick Order Bottom Sheet Drawer (2-Step View) -->
    <div id="lmb-drawer" class="lmb-drawer-overlay" aria-hidden="true">
        <div class="lmb-drawer-content" role="dialog" aria-modal="true" aria-labelledby="lmb-drawer-title">
            <div class="lmb-drawer-handle"></div>

            <div class="lmb-drawer-viewport">
                <div class="lmb-screens-slider" id="lmb-screens-slider">

                    <!-- SCREEN 1: KÊNH ĐẶT MÓN (APPS) -->
                    <div class="lmb-screen lmb-screen-channels">
                        <div class="lmb-drawer-header">
                            <h3 id="lmb-drawer-title">Chọn Kênh Đặt Món Laboon</h3>
                            <p>Giao nhanh tận nơi - Trà sữa pha máy đậm vị</p>
                            <button type="button" class="lmb-close-btn" id="lmb-close-drawer" aria-label="Đóng">&times;</button>
                        </div>

                        <div class="lmb-drawer-list">
                            <!-- Website / iPOS -->
                            <button type="button" class="lmb-option lmb-channel-trigger" data-channel="ipos">
                                <div class="lmb-opt-icon lmb-opt-ipos">
                                    <svg viewBox="0 0 161 35" width="36" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.305664 13.2297C2.64476 13.2297 4.98385 13.2322 7.32052 13.2247C7.52656 13.2247 7.58231 13.2771 7.57988 13.4919C7.57504 20.1791 7.57504 26.8664 7.57988 33.5537C7.57988 33.7684 7.52413 33.8209 7.32052 33.8209C4.98143 33.8134 2.64233 33.8159 0.305664 33.8159C0.305664 26.9538 0.305664 20.0917 0.305664 13.2297Z" fill="#005DA4"/>
                                        <path d="M6.80178 0.107372C7.29384 0.431997 7.37626 0.971372 7.43686 1.49327C7.63319 3.13137 7.64289 4.77197 7.39565 6.40758C7.37868 6.51745 7.35202 6.62483 7.32293 6.7322C7.12659 7.45387 6.94237 7.5987 6.22004 7.5987C4.63964 7.5987 3.05923 7.5987 1.47641 7.5987C1.00616 7.5987 0.824368 7.47135 0.649845 7.01438C0.460778 6.52245 0.409876 6.00305 0.354125 5.48365C0.349277 5.4362 0.368669 5.37627 0.303223 5.3563C0.303223 5.23644 0.303223 5.11657 0.303223 4.99671C0.34443 4.87685 0.34443 4.75699 0.303223 4.63713C0.303223 4.07029 0.303223 3.50594 0.303223 2.9391C0.34443 2.80175 0.34443 2.66441 0.303223 2.52707C0.303223 2.40721 0.303223 2.28735 0.303223 2.16749C0.363821 1.86783 0.337158 1.56069 0.380788 1.25854C0.417147 1.04629 0.458354 0.836528 0.533496 0.63676C0.62803 0.382054 0.775889 0.172297 1.05707 0.107372C2.97197 0.107372 4.88688 0.107372 6.80178 0.107372Z" fill="#F58220"/>
                                        <path d="M37.1785 0.152323C40.366 0.514404 43.0662 3.25124 43.4807 6.53244C43.5219 6.85706 43.5413 7.18169 43.5413 7.50631C43.5438 9.43658 43.5413 11.3668 43.5413 13.2971C43.5413 16.5708 41.384 19.5174 38.3299 20.4089C37.6294 20.6136 36.9119 20.6936 36.1847 20.6936C30.4982 20.6936 24.8116 20.696 19.1251 20.6861C18.8536 20.6861 18.8075 20.771 18.8075 21.0257C18.8148 25.1933 18.8099 29.3635 18.8172 33.5312C18.8172 33.7709 18.7518 33.8234 18.5288 33.8209C16.2891 33.8109 14.0493 33.8109 11.8096 33.8209C11.5697 33.8209 11.5309 33.7435 11.5333 33.5212C11.5382 26.8389 11.5382 20.1567 11.5333 13.4769C11.5333 13.2472 11.5818 13.1797 11.8169 13.1797C19.668 13.1872 27.5191 13.1847 35.3703 13.1847C36.0344 13.1847 36.2744 12.94 36.2744 12.2608C36.2744 11.0098 36.2744 9.75621 36.2744 8.50516C36.2744 7.79348 36.0756 7.59121 35.38 7.59121C27.5458 7.59121 19.7117 7.59121 11.8751 7.59121C11.5357 7.59121 11.5357 7.59121 11.5357 7.23163C11.5357 4.94927 11.5357 2.66941 11.5357 0.387051C11.5357 0.292161 11.5406 0.199768 11.543 0.104877C19.9856 0.104877 28.4281 0.104877 36.8707 0.104877C36.9701 0.172299 37.0816 0.0998833 37.1785 0.152323Z" fill="#005DA4"/>
                                        <path d="M79.561 17.6396C79.5634 17.3324 79.5634 17.0253 79.5634 16.7181C79.5634 16.6682 79.5634 16.6183 79.5634 16.5683C79.5634 16.386 79.5634 16.2037 79.561 16.0215C79.544 14.7954 79.4956 13.5718 79.3938 12.3532H79.3574C79.2435 11.1571 79.0738 9.96596 78.8217 8.78733C78.4387 7.00439 77.8812 5.28638 76.9262 3.72818C75.4742 1.35843 73.4066 0.0399509 70.6676 0.019974C65.6258 -0.0124884 60.5816 -2.88303e-06 55.5374 0.0149798C54.0103 0.019974 52.5996 0.456968 51.3513 1.39089C50.0108 2.39473 49.1261 3.75815 48.4644 5.29387C47.4536 7.64864 47.0343 10.1458 46.8088 12.6878C46.8064 12.7203 46.804 12.7502 46.8016 12.7827L46.7773 12.7852C46.6901 13.9788 46.6489 15.1749 46.6416 16.3735C46.6416 16.4609 46.6392 16.5483 46.6392 16.6357C46.6392 16.8805 46.6392 17.1227 46.6416 17.3674C46.6416 17.5072 46.6416 17.6446 46.644 17.7844H46.6489C46.6537 18.0141 46.6537 18.2414 46.661 18.4711C46.7264 20.716 46.9106 22.9459 47.3833 25.1434C47.7663 26.9263 48.3238 28.6443 49.2788 30.2025C50.7308 32.5723 52.7984 33.8908 55.5374 33.9107C60.5792 33.9432 65.6234 33.9307 70.6676 33.9157C72.1947 33.9108 73.6054 33.4738 74.8537 32.5398C76.1942 31.536 77.0813 30.1726 77.7406 28.6369C78.7514 26.2821 79.1707 23.785 79.3962 21.2429C79.498 20.0917 79.544 18.9406 79.5586 17.7869H79.561C79.561 17.737 79.561 17.6895 79.561 17.6396ZM71.4045 24.4567C71.2857 24.8887 71.1209 25.3032 70.8712 25.6753C70.5537 26.1497 70.1319 26.3895 69.5574 26.387C67.405 26.377 65.2525 26.382 63.1001 26.382C60.9816 26.382 58.8606 26.372 56.7421 26.3895C56.0949 26.3944 55.6368 26.1223 55.3023 25.5779C54.8878 24.9012 54.7084 24.1396 54.5654 23.368C54.2867 21.8922 54.1873 20.3964 54.1412 18.8956C54.1121 17.9617 54.1024 17.0278 54.1097 16.0964C54.117 15.542 54.134 14.9877 54.1582 14.4358C54.2333 12.7652 54.3545 11.0972 54.8005 9.47653C54.9193 9.04453 55.0841 8.63001 55.3338 8.25794C55.6513 7.78349 56.0731 7.54377 56.6476 7.54626C58.8 7.55625 60.9525 7.55126 63.1049 7.55126C65.2234 7.55126 67.3444 7.56125 69.4629 7.54377C70.1101 7.53877 70.5682 7.81096 70.9027 8.35533C71.3172 9.03204 71.4966 9.79366 71.6396 10.5653C71.9183 12.0411 72.0177 13.5368 72.0638 15.0376C72.0904 15.9191 72.1001 16.8031 72.0953 17.6845C72.088 18.2888 72.0735 18.8931 72.0468 19.4999C71.9717 21.168 71.848 22.8361 71.4045 24.4567Z" fill="#005DA4"/>
                                        <path d="M115.408 0.107375C115.45 0.207259 115.43 0.30964 115.43 0.412022C115.433 2.6769 115.433 4.94178 115.43 7.20416C115.43 7.64865 115.488 7.59121 115.067 7.59121C107.007 7.59371 98.9474 7.59121 90.8879 7.59121C90.6503 7.59121 90.42 7.6012 90.231 7.7735C90.0661 7.92333 89.9813 8.11561 89.9813 8.34035C89.9789 9.70377 89.9765 11.0672 89.9837 12.4306C89.9862 12.9051 90.2891 13.1847 90.7739 13.1847C96.5768 13.1847 102.38 13.1847 108.183 13.1847C111.528 13.1847 114.429 15.5021 115.227 18.8057C115.357 19.3476 115.428 19.8995 115.43 20.4588C115.435 22.484 115.437 24.5066 115.43 26.5318C115.418 30.0153 112.718 33.2141 109.37 33.721C108.966 33.7834 108.561 33.8159 108.154 33.8159C99.7861 33.8134 91.4187 33.8159 83.0513 33.8159C82.7144 33.8159 82.7144 33.8159 82.7144 33.4563C82.7144 31.1914 82.7144 28.9265 82.7144 26.6641C82.7144 26.3295 82.7144 26.3295 83.0319 26.3295C91.0745 26.3295 99.1171 26.3295 107.16 26.3295C107.235 26.3295 107.31 26.332 107.385 26.3295C107.947 26.312 108.163 26.0848 108.166 25.503C108.168 24.1745 108.168 22.8436 108.166 21.5151C108.166 20.9732 107.892 20.6936 107.366 20.6936C101.597 20.6936 95.8254 20.701 90.0564 20.6911C87.0871 20.6861 84.9177 19.2627 83.4876 16.6183C82.9471 15.6194 82.7241 14.5207 82.7192 13.382C82.7119 11.3918 82.7144 9.40162 82.7168 7.41142C82.7241 3.87302 85.3346 0.749132 88.733 0.202265C88.8469 0.184785 88.9633 0.167305 89.0796 0.149825C89.1766 0.0973862 89.2881 0.169802 89.3826 0.104877C98.0554 0.107375 106.731 0.107375 115.408 0.107375Z" fill="#005DA4"/>
                                        <path d="M120.952 33.4987C120.295 33.4987 119.638 33.4937 118.979 33.5037C118.814 33.5062 118.749 33.4738 118.751 33.284C118.758 31.9131 118.758 30.5397 118.751 29.1687C118.751 29.0114 118.792 28.9665 118.945 28.969C120.285 28.974 121.623 28.9765 122.964 28.969C123.126 28.969 123.153 29.0239 123.153 29.1737C123.148 30.5446 123.148 31.9181 123.153 33.289C123.153 33.4563 123.112 33.5087 122.947 33.5062C122.283 33.4937 121.616 33.4987 120.952 33.4987Z" fill="#005DA4"/>
                                        <path d="M124.127 13.1373C124.825 13.1373 125.526 13.1473 126.224 13.1323C126.44 13.1273 126.537 13.1847 126.607 13.4095C127.906 17.4898 129.217 21.565 130.519 25.6428C130.592 25.8726 130.694 26.0374 130.941 26.0324C131.181 26.0299 131.307 25.8701 131.38 25.6453C132.23 22.9809 133.086 20.319 133.939 17.6546C134.402 16.2087 134.87 14.7629 135.323 13.3146C135.374 13.1523 135.457 13.1323 135.595 13.1348C137.052 13.1373 138.508 13.1423 139.965 13.1323C140.195 13.1298 140.2 13.1972 140.132 13.392C138.559 17.9168 136.991 22.444 135.423 26.9713C134.875 28.5495 134.33 30.1276 133.782 31.7083C133.428 32.7296 132.824 33.4937 131.746 33.731C130.107 34.093 128.677 33.4263 128.081 31.6908C125.989 25.5954 123.88 19.5049 121.776 13.4145C121.681 13.1423 121.681 13.1423 121.951 13.1423C122.678 13.1348 123.402 13.1373 124.127 13.1373Z" fill="#005DA4"/>
                                        <path d="M156.332 27.0487C156.332 26.9438 156.332 26.8414 156.332 26.7415C156.332 22.3067 156.334 17.8743 156.327 13.4394C156.327 13.1897 156.387 13.1273 156.627 13.1298C157.9 13.1423 159.175 13.1398 160.447 13.1323C160.656 13.1298 160.726 13.1673 160.726 13.407C160.719 20.0118 160.719 26.6142 160.726 33.219C160.726 33.4638 160.654 33.5087 160.435 33.5062C159.187 33.4962 157.936 33.4638 156.69 33.5112C155.335 33.5612 154.327 32.9843 153.585 31.8631C152.465 30.1701 151.365 28.467 150.257 26.7665C148.747 24.4467 147.239 22.1244 145.732 19.8046C145.712 19.7771 145.695 19.7471 145.674 19.7222C145.606 19.6398 145.514 19.5674 145.417 19.6048C145.329 19.6398 145.375 19.7571 145.375 19.837C145.373 24.2794 145.373 28.7218 145.373 33.1641C145.373 33.5537 145.422 33.5037 145.041 33.5037C143.768 33.5062 142.493 33.4987 141.221 33.5087C141.022 33.5112 140.974 33.4513 140.974 33.2515C140.978 26.6317 140.978 20.0093 140.978 13.3895C140.978 13.2696 140.935 13.1348 141.148 13.1373C142.547 13.1448 143.945 13.1398 145.344 13.1423C146.442 13.1448 147.283 13.6667 147.95 14.5332C148.124 14.7604 148.294 14.9951 148.451 15.2374C150.919 19.0405 153.384 22.8461 155.852 26.6492C155.966 26.8215 156.034 27.0662 156.332 27.0487Z" fill="#005DA4"/>
                                    </svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>Đặt Trực Tiếp Qua Web (iPOS)</strong>
                                    <span>Tích điểm thành viên &amp; Thực đơn đầy đủ nhất</span>
                                </div>
                                <span class="lmb-opt-badge badge-hot">Ưu tiên</span>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- ShopeeFood -->
                            <button type="button" class="lmb-option lmb-channel-trigger" data-channel="shopee">
                                <div class="lmb-opt-icon lmb-opt-logo">
                                    <img src="https://laboon.vn/wp-content/uploads/2023/10/shopee.png" alt="ShopeeFood" width="42" height="42" loading="eager" />
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>ShopeeFood</strong>
                                    <span>Nhiều mã Freeship &amp; Khuyến mãi độc quyền</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- GrabFood -->
                            <button type="button" class="lmb-option lmb-channel-trigger" data-channel="grab">
                                <div class="lmb-opt-icon lmb-opt-logo">
                                    <img src="https://laboon.vn/wp-content/uploads/2023/10/grabfood-150x150.png" alt="GrabFood" width="42" height="42" loading="eager" />
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>GrabFood</strong>
                                    <span>Giao hàng siêu tốc trong 20 phút</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- BeFood -->
                            <button type="button" class="lmb-option lmb-channel-trigger" data-channel="be">
                                <div class="lmb-opt-icon lmb-opt-logo">
                                    <img src="https://laboon.vn/wp-content/uploads/2023/10/be.png" alt="BeFood" width="42" height="42" loading="eager" />
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>BeFood</strong>
                                    <span>Đặt món nhanh qua ứng dụng Be</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- Xem Menu gốc trên web -->
                            <a href="https://laboon.vn/menu/" class="lmb-option lmb-opt-menu">
                                <div class="lmb-opt-icon lmb-opt-logo lmb-opt-laboon">
                                    <img src="https://laboon.vn/wp-content/uploads/2025/07/cropped-favicon_2_Artboard-11-192x192.webp" alt="Menu Laboon" width="42" height="42" loading="eager" />
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>Xem Toàn Bộ Menu Website</strong>
                                    <span>Hình ảnh sắc nét &amp; Bảng giá chi tiết tất cả món</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </a>
                        </div>
                    </div>

                    <!-- SCREEN 2: CHỌN CHI NHÁNH CỤ THỂ (BRANCHES) -->
                    <div class="lmb-screen lmb-screen-branches">
                        <div class="lmb-drawer-header lmb-header-branches">
                            <button type="button" id="lmb-back-step" class="lmb-back-btn" aria-label="Quay lại">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                                <span>Quay lại</span>
                            </button>
                            <div class="lmb-header-title-wrap">
                                <div class="lmb-header-channel-badge">
                                    <img id="lmb-header-channel-icon" src="https://laboon.vn/wp-content/uploads/2023/10/shopee.png" alt="" width="22" height="22" />
                                    <h3 id="lmb-branch-channel-title">ShopeeFood Laboon</h3>
                                </div>
                                <p>Chọn chi nhánh gần bạn nhất để đặt món</p>
                            </div>
                            <button type="button" class="lmb-close-btn" id="lmb-close-drawer-2" aria-label="Đóng">&times;</button>
                        </div>

                        <div class="lmb-drawer-list">
                            <!-- Chi nhánh 1: Quận 1 -->
                            <a href="#" target="_blank" rel="noopener" class="lmb-option lmb-branch-item" id="lmb-branch-q1">
                                <div class="lmb-opt-icon lmb-branch-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <div class="lmb-branch-top-line">
                                        <strong>Quận 1</strong>
                                        <span class="lmb-branch-tag">08:00 - 22:00</span>
                                    </div>
                                    <span class="lmb-branch-addr">233/3 Nguyễn Trãi, P. Cầu Ông Lãnh, Q.1</span>
                                </div>
                                <span class="lmb-branch-action">Đặt ngay ↗</span>
                            </a>

                            <!-- Chi nhánh 2: Quận 4 -->
                            <a href="#" target="_blank" rel="noopener" class="lmb-option lmb-branch-item" id="lmb-branch-q4">
                                <div class="lmb-opt-icon lmb-branch-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <div class="lmb-branch-top-line">
                                        <strong>Quận 4</strong>
                                        <span class="lmb-branch-tag">08:00 - 22:30</span>
                                    </div>
                                    <span class="lmb-branch-addr">246 Khánh Hội, Phường 6, Q.4</span>
                                </div>
                                <span class="lmb-branch-action">Đặt ngay ↗</span>
                            </a>

                            <!-- Chi nhánh 3: Quận 7 -->
                            <a href="#" target="_blank" rel="noopener" class="lmb-option lmb-branch-item" id="lmb-branch-q7">
                                <div class="lmb-opt-icon lmb-branch-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <div class="lmb-branch-top-line">
                                        <strong>Quận 7</strong>
                                        <span class="lmb-branch-tag">08:00 - 22:30</span>
                                    </div>
                                    <span class="lmb-branch-addr">79 Đường số 17, P. Tân Quy, Q.7</span>
                                </div>
                                <span class="lmb-branch-action">Đặt ngay ↗</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Styles for Mobile CTA Bar -->
    <style>
    /* Mobile-only display */
    @media (min-width: 769px) {
        #laboon-mobile-bar,
        #lmb-drawer {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        /* Add bottom clearance for mobile body & footer */
        body {
            padding-bottom: 74px !important;
        }

        /* Reposition Zalo widget above sticky bar when closed */
        .zalo-chat-widget,
        iframe[id*="zalo"],
        div[class*="zalo-chat"] {
            bottom: 84px !important;
            right: 16px !important;
        }

        /* Completely hide Zalo & Back-to-Top when Drawer is OPEN to eliminate overlaps */
        body.lmb-drawer-open .zalo-chat-widget,
        body.lmb-drawer-open iframe[id*="zalo"],
        body.lmb-drawer-open div[class*="zalo"],
        body.lmb-drawer-open .zalo-float,
        body.lmb-drawer-open #back-to-top,
        body.lmb-drawer-open .back-to-top,
        body.lmb-drawer-open [class*="go-top"],
        body.lmb-drawer-open [class*="scroll-to-top"],
        body.lmb-drawer-open [id*="scroll-to-top"] {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }

        /* Fixed Bottom Bar */
        .laboon-mobile-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 99999;
            height: 64px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(22, 71, 105, 0.12);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 4px 10px;
            padding-bottom: calc(4px + env(safe-area-inset-bottom, 0px));
            box-sizing: border-box;
            font-family: inherit;
        }

        /* Left/Right Icon Item */
        .lmb-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            color: #164769 !important;
            padding: 4px 0;
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .lmb-item:active {
            transform: scale(0.92);
        }
        .lmb-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #164769;
            margin-bottom: 2px;
        }
        .lmb-text {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #164769;
            white-space: nowrap;
        }

        /* Hero Center Button (Đặt Món Ngay) */
        .lmb-hero-btn {
            position: relative;
            flex: 1.5;
            height: 48px;
            margin: 0 8px;
            border: none;
            border-radius: 28px;
            background: linear-gradient(135deg, #ff6b00 0%, #ff8f00 100%);
            color: #ffffff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(255, 107, 0, 0.42);
            font-family: inherit;
            transition: all 0.2s ease;
            outline: none;
        }
        .lmb-hero-btn:active {
            transform: scale(0.95);
            box-shadow: 0 2px 8px rgba(255, 107, 0, 0.3);
        }
        .lmb-hero-icon {
            display: flex;
            align-items: center;
        }
        .lmb-hero-text {
            font-size: 12.5px;
            font-weight: 800;
            letter-spacing: 0.4px;
            color: #ffffff;
            white-space: nowrap;
        }

        /* Pulse aura effect */
        .lmb-pulse {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 28px;
            border: 2px solid rgba(255, 107, 0, 0.6);
            animation: lmb-pulse-anim 2s infinite ease-out;
            pointer-events: none;
        }
        @keyframes lmb-pulse-anim {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.15, 1.25); opacity: 0; }
        }

        /* Drawer Overlay */
        .lmb-drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.58);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 9999999 !important;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            display: flex;
            align-items: flex-end;
        }
        .lmb-drawer-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Drawer Sheet */
        .lmb-drawer-content {
            width: 100%;
            max-height: 88vh;
            background: #ffffff;
            border-radius: 24px 24px 0 0;
            padding: 14px 18px calc(20px + env(safe-area-inset-bottom, 0px));
            box-sizing: border-box;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
        }
        .lmb-drawer-overlay.active .lmb-drawer-content {
            transform: translateY(0);
        }

        /* Handle bar */
        .lmb-drawer-handle {
            width: 42px;
            height: 5px;
            background: #d1d5db;
            border-radius: 4px;
            margin: 0 auto 12px;
        }

        /* 2-Screen Viewport & Slider */
        .lmb-drawer-viewport {
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        .lmb-screens-slider {
            display: flex;
            width: 200%;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .lmb-screens-slider.show-branches {
            transform: translateX(-50%);
        }
        .lmb-screen {
            width: 50%;
            box-sizing: border-box;
            flex-shrink: 0;
            padding-right: 4px;
        }
        .lmb-screen-branches {
            padding-left: 4px;
            padding-right: 0;
        }

        /* Drawer Header */
        .lmb-drawer-header {
            position: relative;
            text-align: center;
            margin-bottom: 14px;
            padding: 0 28px;
        }
        .lmb-drawer-header h3 {
            margin: 0 0 3px;
            font-size: 16.5px;
            font-weight: 800;
            color: #164769;
        }
        .lmb-drawer-header p {
            margin: 0;
            font-size: 12.5px;
            color: #6b7280;
        }
        .lmb-close-btn {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Header for Step 2 */
        .lmb-header-branches {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 0 12px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 12px;
            text-align: left;
        }
        .lmb-header-title-wrap {
            flex: 1;
            padding: 0 10px;
            text-align: center;
        }
        .lmb-header-title-wrap h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
            color: #164769;
        }
        .lmb-header-title-wrap p {
            margin: 2px 0 0;
            font-size: 11.5px;
            color: #64748b;
        }
        .lmb-back-btn {
            background: #f1f5f9;
            border: none;
            border-radius: 20px;
            padding: 6px 10px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            color: #164769;
            cursor: pointer;
        }
        .lmb-header-branches .lmb-close-btn {
            position: static;
        }

        /* List & Options */
        .lmb-drawer-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
            max-height: 60vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .lmb-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            text-decoration: none !important;
            transition: all 0.2s ease;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
            text-align: left;
            font-family: inherit;
        }
        .lmb-option:active {
            background: #eef2f6;
            transform: scale(0.985);
        }
        .lmb-opt-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 0;
            box-sizing: border-box;
        }
        .lmb-opt-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 11px;
        }
        .lmb-opt-icon.lmb-opt-ipos {
            background: #ffffff;
            border: 1.5px solid #dbeafe;
            padding: 2px 4px;
            box-sizing: border-box;
        }
        .lmb-opt-icon.lmb-opt-ipos svg {
            width: 36px;
            height: 16px;
            display: block;
        }
        .lmb-opt-icon.lmb-opt-laboon {
            background: #ffffff;
            border: 1.5px solid #dcfce7;
            padding: 2px;
            box-sizing: border-box;
        }
        .lmb-opt-icon.lmb-opt-laboon img {
            object-fit: contain;
        }
        .lmb-header-channel-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }
        .lmb-header-channel-badge img {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .lmb-opt-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .lmb-opt-info strong {
            font-size: 13.5px;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .lmb-opt-info span {
            font-size: 11.5px;
            color: #64748b;
            line-height: 1.3;
        }
        .lmb-opt-arrow {
            font-size: 20px;
            color: #94a3b8;
            font-weight: 300;
            line-height: 1;
        }
        .lmb-opt-badge {
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            background: #fee2e2;
            color: #dc2626;
            flex-shrink: 0;
        }
        .badge-hot {
            background: #ffedd5;
            color: #ea580c;
        }

        /* Branch Card Item Specifics */
        .lmb-branch-item {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            padding: 12px 14px;
        }
        .lmb-branch-item:hover,
        .lmb-branch-item:active {
            border-color: #ff6b00;
            background: #fffaf5;
        }
        .lmb-branch-icon {
            background: #e2e8f0;
            color: #164769;
        }
        .lmb-branch-top-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 3px;
        }
        .lmb-branch-top-line strong {
            font-size: 15px;
            color: #0f172a;
            font-weight: 800;
            white-space: nowrap;
            overflow: visible;
            text-overflow: clip;
        }
        .lmb-branch-tag {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            background: #ecfdf5;
            color: #059669;
            border-radius: 8px;
            white-space: nowrap;
        }
        .lmb-branch-addr {
            font-size: 11.5px;
            color: #475569;
        }
        .lmb-branch-action {
            font-size: 11.5px;
            font-weight: 800;
            color: #ff6b00;
            padding: 6px 10px;
            border-radius: 16px;
            background: #fff7ed;
            white-space: nowrap;
            flex-shrink: 0;
        }
    }
    </style>

    <!-- JavaScript interaction -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var openBtn       = document.getElementById('lmb-open-modal');
        var drawer        = document.getElementById('lmb-drawer');
        var slider        = document.getElementById('lmb-screens-slider');
        var backBtn       = document.getElementById('lmb-back-step');
        var closeBtn1     = document.getElementById('lmb-close-drawer');
        var closeBtn2     = document.getElementById('lmb-close-drawer-2');
        var channelTitle  = document.getElementById('lmb-branch-channel-title');
        var headerIcon    = document.getElementById('lmb-header-channel-icon');
        
        var branchQ1      = document.getElementById('lmb-branch-q1');
        var branchQ4      = document.getElementById('lmb-branch-q4');
        var branchQ7      = document.getElementById('lmb-branch-q7');

        if (!openBtn || !drawer || !slider) return;

        // Data map for all food delivery channels & 3 branches
        var channelMap = {
            'ipos': {
                title: 'Web iPOS (Tích Điểm)',
                icon: 'https://laboon.vn/wp-content/uploads/2025/07/cropped-favicon_2_Artboard-11-192x192.webp',
                themeColor: '#005DA4',
                branches: {
                    q1: 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=117986',
                    q4: 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=73661',
                    q7: 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=93349'
                }
            },
            'shopee': {
                title: 'ShopeeFood Laboon',
                icon: 'https://laboon.vn/wp-content/uploads/2023/10/shopee.png',
                themeColor: '#ee4d2d',
                branches: {
                    q1: 'https://shopeefood.vn/ho-chi-minh/laboon-tra-sua-cafe-cao-thang',
                    q4: 'https://shopeefood.vn/ho-chi-minh/laboon-tra-sua-cafe-khanh-hoi',
                    q7: 'https://shopeefood.vn/ho-chi-minh/laboon-tra-sua-cafe-quan-7'
                }
            },
            'grab': {
                title: 'GrabFood Laboon',
                icon: 'https://laboon.vn/wp-content/uploads/2023/10/grabfood-150x150.png',
                themeColor: '#00b14f',
                branches: {
                    q1: 'https://r.grab.com/o/MbiAFbA3',
                    q4: 'https://food.grab.com/vn/vi/restaurants?search=laboon+khanh+hoi',
                    q7: 'https://food.grab.com/vn/vi/restaurants?search=laboon+quan+7'
                }
            },
            'be': {
                title: 'BeFood Laboon',
                icon: 'https://laboon.vn/wp-content/uploads/2023/10/be.png',
                themeColor: '#eab308',
                branches: {
                    q1: 'https://food.be.com.vn/resto?id=115460',
                    q4: 'https://food.be.com.vn/resto?id=115460',
                    q7: 'https://food.be.com.vn/resto?id=115460'
                }
            }
        };

        function openDrawer() {
            drawer.classList.add('active');
            drawer.setAttribute('aria-hidden', 'false');
            document.body.classList.add('lmb-drawer-open');
            document.body.style.overflow = 'hidden';
            resetToStep1();
        }

        function closeDrawer() {
            drawer.classList.remove('active');
            drawer.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('lmb-drawer-open');
            document.body.style.overflow = '';
            setTimeout(resetToStep1, 300);
        }

        function resetToStep1() {
            slider.classList.remove('show-branches');
        }

        function goToStep2(channelKey) {
            var data = channelMap[channelKey];
            if (!data) return;

            if (channelTitle) {
                channelTitle.textContent = data.title;
            }

            if (headerIcon && data.icon) {
                headerIcon.src = data.icon;
            }

            if (branchQ1) branchQ1.href = data.branches.q1;
            if (branchQ4) branchQ4.href = data.branches.q4;
            if (branchQ7) branchQ7.href = data.branches.q7;

            // Highlight branch icons with channel theme color
            var branchIcons = drawer.querySelectorAll('.lmb-branch-icon');
            branchIcons.forEach(function(icon) {
                icon.style.color = data.themeColor;
            });

            slider.classList.add('show-branches');
        }

        // Open button click
        openBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openDrawer();
        });

        // Close button clicks
        if (closeBtn1) closeBtn1.addEventListener('click', closeDrawer);
        if (closeBtn2) closeBtn2.addEventListener('click', closeDrawer);

        // Back button click (Step 2 -> Step 1)
        if (backBtn) {
            backBtn.addEventListener('click', function(e) {
                e.preventDefault();
                resetToStep1();
            });
        }

        // Channel triggers (iPOS, Shopee, Grab, Be)
        var triggers = drawer.querySelectorAll('.lmb-channel-trigger');
        triggers.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var channel = this.getAttribute('data-channel');
                goToStep2(channel);
            });
        });

        // Close on backdrop click
        drawer.addEventListener('click', function(e) {
            if (e.target === drawer) {
                closeDrawer();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawer.classList.contains('active')) {
                closeDrawer();
            }
        });
    });
    </script>
    <?php
}
