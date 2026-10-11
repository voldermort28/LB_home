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
                                <div class="lmb-opt-icon" style="background:#164769;color:#fff;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
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
                                <div class="lmb-opt-icon" style="background:#ee4d2d;color:#fff;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6h-2c0-2.76-2.24-5-5-5S7 3.24 7 6H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.66 0 3 1.34 3 3h-6c0-1.66 1.34-3 3-3zm7 17H5V8h14v12z"/></svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>ShopeeFood</strong>
                                    <span>Nhiều mã Freeship &amp; Khuyến mãi độc quyền</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- GrabFood -->
                            <button type="button" class="lmb-option lmb-channel-trigger" data-channel="grab">
                                <div class="lmb-opt-icon" style="background:#00b14f;color:#fff;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5zm4 4h-2v-6h2v6zm0-8h-2V7h2v1z"/></svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>GrabFood</strong>
                                    <span>Giao hàng siêu tốc trong 20 phút</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- BeFood -->
                            <button type="button" class="lmb-option lmb-channel-trigger" data-channel="be">
                                <div class="lmb-opt-icon" style="background:#ffde00;color:#164769;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                </div>
                                <div class="lmb-opt-info">
                                    <strong>BeFood</strong>
                                    <span>Đặt món nhanh qua ứng dụng Be</span>
                                </div>
                                <span class="lmb-opt-arrow">&rsaquo;</span>
                            </button>

                            <!-- Xem Menu gốc trên web -->
                            <a href="https://laboon.vn/menu/" class="lmb-option lmb-opt-menu">
                                <div class="lmb-opt-icon" style="background:#164769;color:#fff;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
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
                                <h3 id="lmb-branch-channel-title">ShopeeFood</h3>
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
                                        <strong>Chi nhánh Quận 1</strong>
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
                                        <strong>Chi nhánh Quận 4</strong>
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
                                        <strong>Chi nhánh Quận 7</strong>
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
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #164769;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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
            font-size: 14px;
            color: #0f172a;
            font-weight: 800;
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
        
        var branchQ1      = document.getElementById('lmb-branch-q1');
        var branchQ4      = document.getElementById('lmb-branch-q4');
        var branchQ7      = document.getElementById('lmb-branch-q7');

        if (!openBtn || !drawer || !slider) return;

        // Data map for all food delivery channels & 3 branches
        var channelMap = {
            'ipos': {
                title: 'Web iPOS (Tích Điểm)',
                themeColor: '#164769',
                branches: {
                    q1: 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=117986',
                    q4: 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=73661',
                    q7: 'https://order.ipos.vn/menu?pos_parent=BRAND-QH7Z&pos_id=93349'
                }
            },
            'shopee': {
                title: 'ShopeeFood Laboon',
                themeColor: '#ee4d2d',
                branches: {
                    q1: 'https://shopeefood.vn/ho-chi-minh/laboon-tra-sua-cafe-cao-thang',
                    q4: 'https://shopeefood.vn/ho-chi-minh/laboon-tra-sua-cafe-khanh-hoi',
                    q7: 'https://shopeefood.vn/ho-chi-minh/laboon-tra-sua-cafe-quan-7'
                }
            },
            'grab': {
                title: 'GrabFood Laboon',
                themeColor: '#00b14f',
                branches: {
                    q1: 'https://r.grab.com/o/MbiAFbA3',
                    q4: 'https://food.grab.com/vn/vi/restaurants?search=laboon+khanh+hoi',
                    q7: 'https://food.grab.com/vn/vi/restaurants?search=laboon+quan+7'
                }
            },
            'be': {
                title: 'BeFood Laboon',
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
