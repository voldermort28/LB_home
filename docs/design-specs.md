# Design Specifications: Laboon Store Locator (Option A - Tabs)

## 🎨 Color Palette
| Name | Hex | Usage |
|------|-----|-------|
| Primary Teal | `#164769` | Main headings, brand identity, active tab backgrounds |
| Vibrant Green | `#8cc454` | Accents, Grab delivery badge, success states |
| Warm Orange | `#ff6b00` | ShopeeFood badge, hover states, playful highlights |
| Background Flat | `#f8f9fa` | Main page background (soft off-white) |
| Surface White | `#ffffff` | Cards, tabs, containers |
| Text Primary | `#2d3748` | Body text, store names |
| Text Muted | `#718096` | Addresses, opening hours, secondary info |

## 📝 Typography
| Element | Font | Size | Weight | Line Height |
|---------|------|------|--------|-------------|
| H1 (Page Title)| Montserrat / Roboto | 40px | 800 (Extra Bold) | 1.2 |
| H2 (Card Title)| Montserrat / Roboto | 24px | 700 (Bold) | 1.3 |
| Tab Labels | Roboto | 18px | 600 (Semi-Bold) | 1.4 |
| Body Text | Roboto | 15px | 400 (Regular) | 1.6 |
| Small Text | Roboto | 13px | 400 (Regular) | 1.5 |

## 📐 Spacing System (Padding & Margin)
| Name | Value | Usage |
|------|-------|-------|
| xs | 8px | Gap between icon and text |
| sm | 16px | Padding inside small pills/badges |
| md | 24px | Padding inside tabs, gap between card elements |
| lg | 32px | Padding inside the main store detail card |
| xl | 48px | Gap between left column (Contact) and right column (Tabs) |
| 2xl | 64px | Top and bottom section padding |

## 🔲 Border Radius
| Name | Value | Usage |
|------|-------|-------|
| sm | 8px | Small buttons, icons |
| md | 16px | Store detail images, vertical tabs |
| lg | 24px | Main layout cards (Contact Card, Store Detail Card) |
| full | 9999px| Pill buttons (Delivery Apps), circular icons |

## 🌫️ Shadows
| Name | Value | Usage |
|------|-------|-------|
| soft | `0 10px 30px rgba(22, 71, 105, 0.08)` | Main cards (Contact, Store Info) |
| hover | `0 15px 40px rgba(22, 71, 105, 0.15)` | Interactive elements on hover |
| tab | `0 4px 15px rgba(0, 0, 0, 0.05)` | Inactive tabs |

## 📱 Breakpoints & Responsive Behavior
| Name | Width | Description |
|------|-------|-------------|
| mobile | `< 768px` | Stack everything vertically. Tabs turn into a horizontal scrollable row or an accordion. |
| tablet | `768px - 1024px` | Left/Right columns stack, but Tabs remain vertical alongside the Store Card. |
| desktop| `> 1024px` | Full 2-column layout (Contact left, Tabs + Store Card right). |

## 🖼️ Component Specs (Elementor Implementation Guide)

### 1. Contact Card (Left Column)
- **Background**: White (`#ffffff`)
- **Border Radius**: 24px
- **Box Shadow**: `soft`
- **Content**: 
  - Circular icons with light green/blue background.
  - Text stacked vertically (Email/Phone label + Actual value).

### 2. Vertical Tabs (Middle Column)
- **Normal State**: White background, Primary Text color, `tab` shadow.
- **Active/Hover State**: Primary Teal (`#164769`) background, White text.
- **Border Radius**: 16px (slightly smaller than main cards).

### 3. Store Detail Card (Right Column)
- **Image Area**: Top-aligned, 100% width, `16px` border-radius (top-left, top-right), `object-fit: cover` with height `~250px`.
- **Text Area**: `32px` padding.
- **Delivery Buttons Area**: Flexbox row, gap `12px`.
  - **Grab Button**: Green background (`#8cc454`), White text, Pill shape (`9999px` radius).
  - **Shopee Button**: Orange background (`#ff6b00`), White text, Pill shape.
  - **Be / Web Button**: Yellow / Teal background respectively.
- **Map Button**: Ghost button style (Teal outline, transparent background) or a secondary link style with an arrow icon.
