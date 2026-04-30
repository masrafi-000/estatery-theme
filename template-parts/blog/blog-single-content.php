<?php
/**
 * Component: Single Blog Post — Professional News Portal
 */
$post_id     = get_the_ID();
$author_name = get_post_meta($post_id, '_author_name', true) ?: 'Admin';
$author_role = get_post_meta($post_id, '_author_designation', true) ?: 'Estate Advisor';
$image       = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id, 'full') : "https://images.pexels.com/photos/3944454/pexels-photo-3944454.jpeg?auto=compress&cs=tinysrgb&w=1600";
$categories  = get_the_terms($post_id, 'blog_category');
$category    = !empty($categories) ? $categories[0]->name : 'Journal';
$cat_slug    = !empty($categories) ? $categories[0]->slug : 'journal';

// Reading time
$content    = get_post_field('post_content', $post_id);
$word_count = str_word_count(strip_tags($content));
$read_time  = ceil($word_count / 200);

// Related posts (same category, exclude current)
$related_posts = [];
if (!empty($categories)) {
    $related_posts = get_posts([
        'post_type'      => 'blog',
        'posts_per_page' => 3,
        'post__not_in'   => [$post_id],
        'tax_query'      => [[
            'taxonomy' => 'blog_category',
            'field'    => 'term_id',
            'terms'    => $categories[0]->term_id,
        ]],
    ]);
}
?>

<!— FONTS —>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,300;1,8..60,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ============================================================
   CSS CUSTOM PROPERTIES
   ============================================================ */
:root {
    --ink:        #0A0A0B;
    --ink-mid:    #3D3D42;
    --ink-muted:  #7A7A85;
    --ink-faint:  #B8B8C0;
    --rule:       #E2E2E8;
    --surface:    #F7F7F9;
    --white:      #FFFFFF;
    --accent:     #C8102E;        /* editorial red */
    --accent-dk:  #9C0D24;
    --accent-bg:  #FFF0F2;
    --tag-bg:     #F0F0F5;

    --font-display: 'Playfair Display', Georgia, serif;
    --font-body:    'Source Serif 4', Georgia, serif;
    --font-ui:      'DM Sans', system-ui, sans-serif;

    --max-w:      760px;
    --content-w:  1200px;
    --radius-sm:  4px;
    --radius-md:  8px;
    --radius-lg:  16px;
}

/* ============================================================
   GLOBAL RESET (scoped to article page)
   ============================================================ */
.np-wrap *,
.np-wrap *::before,
.np-wrap *::after { box-sizing: border-box; margin: 0; padding: 0; }

.np-wrap {
    font-family: var(--font-ui);
    color: var(--ink);
    background: var(--white);
    -webkit-font-smoothing: antialiased;
}

/* ============================================================
   TOP BAR
   ============================================================ */
.np-topbar {
    background: var(--ink);
    color: var(--white);
    padding: 0 24px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
    letter-spacing: 0.08em;
    font-weight: 500;
    font-family: var(--font-ui);
    text-transform: uppercase;
}

.np-topbar__date { color: #9999AA; }
.np-topbar__edition { color: var(--white); }
.np-topbar__share {
    display: flex;
    align-items: center;
    gap: 14px;
}
.np-topbar__share a {
    color: #9999AA;
    text-decoration: none;
    transition: color .2s;
    display: flex;
    align-items: center;
    gap: 5px;
}
.np-topbar__share a:hover { color: var(--white); }

/* ============================================================
   SECTION LABEL (running header)
   ============================================================ */
.np-section-label {
    border-bottom: 1px solid var(--rule);
    padding: 14px 0;
}
.np-section-label__inner {
    max-width: var(--content-w);
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.np-section-label__tag {
    background: var(--accent);
    color: var(--white);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    padding: 4px 12px;
    border-radius: var(--radius-sm);
}
.np-section-label__trail {
    font-size: 12px;
    color: var(--ink-muted);
    font-family: var(--font-ui);
    display: flex;
    align-items: center;
    gap: 8px;
}
.np-section-label__trail a {
    color: var(--ink-muted);
    text-decoration: none;
    transition: color .2s;
}
.np-section-label__trail a:hover { color: var(--ink); }
.np-section-label__trail span { color: var(--ink-faint); }

/* ============================================================
   HERO
   ============================================================ */
.np-hero {
    max-width: var(--content-w);
    margin: 0 auto;
    padding: 48px 24px 0;
}

.np-hero__category {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--accent);
    font-family: var(--font-ui);
    margin-bottom: 20px;
}
.np-hero__category::before {
    content: '';
    display: block;
    width: 24px;
    height: 2px;
    background: var(--accent);
    border-radius: 2px;
}

.np-hero__headline {
    font-family: var(--font-display);
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 900;
    line-height: 1.08;
    color: var(--ink);
    letter-spacing: -0.025em;
    max-width: 880px;
    margin-bottom: 24px;
}

.np-hero__deck {
    font-family: var(--font-body);
    font-size: 1.175rem;
    font-weight: 300;
    line-height: 1.65;
    color: var(--ink-mid);
    max-width: 760px;
    margin-bottom: 32px;
    font-style: italic;
}

/* ============================================================
   BYLINE BAR
   ============================================================ */
.np-byline {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 24px;
    padding: 20px 0;
    border-top: 2px solid var(--ink);
    border-bottom: 1px solid var(--rule);
    margin-bottom: 0;
}

.np-byline__author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.np-byline__avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--ink);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
}

.np-byline__info { line-height: 1.3; }
.np-byline__name {
    font-size: 14px;
    font-weight: 600;
    color: var(--ink);
    font-family: var(--font-ui);
}
.np-byline__role {
    font-size: 11px;
    color: var(--ink-muted);
    font-family: var(--font-ui);
    letter-spacing: 0.03em;
}

.np-byline__meta {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-left: auto;
    flex-wrap: wrap;
}

.np-byline__meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--ink-muted);
    font-family: var(--font-ui);
    letter-spacing: 0.02em;
}
.np-byline__meta-item svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    opacity: 0.6;
}

.np-byline__read-badge {
    background: var(--accent-bg);
    border: 1px solid #FFCDD4;
    color: var(--accent);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 30px;
    font-family: var(--font-ui);
}

/* ============================================================
   MAIN LAYOUT (article + sidebar)
   ============================================================ */
.np-layout {
    max-width: var(--content-w);
    margin: 0 auto;
    padding: 0 24px 80px;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 60px;
    align-items: start;
}

@media (max-width: 960px) {
    .np-layout { grid-template-columns: 1fr; gap: 40px; }
    .np-sidebar { display: none; }
}

/* ============================================================
   FEATURED IMAGE
   ============================================================ */
.np-featured-img {
    position: relative;
    margin: 36px 0 0;
}

.np-featured-img__wrap {
    width: 100%;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: var(--surface);
}

.np-featured-img__wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 6s ease;
}
.np-featured-img__wrap:hover img { transform: scale(1.02); }

.np-featured-img__caption {
    margin-top: 10px;
    font-size: 12px;
    color: var(--ink-muted);
    font-family: var(--font-ui);
    font-style: italic;
    line-height: 1.5;
    padding-left: 12px;
    border-left: 2px solid var(--rule);
}

/* ============================================================
   ARTICLE BODY
   ============================================================ */
.np-article {
    padding-top: 48px;
}

.np-article__body {
    font-family: var(--font-body);
    font-size: 1.1rem;
    line-height: 1.85;
    color: var(--ink-mid);
    font-weight: 300;
}

/* Drop cap */
.np-article__body > p:first-of-type::first-letter {
    float: left;
    font-family: var(--font-display);
    font-size: 5.2rem;
    line-height: 0.72;
    font-weight: 900;
    color: var(--ink);
    margin-right: 12px;
    margin-top: 8px;
    shape-outside: margin-box;
}

.np-article__body p { margin-bottom: 2rem; }

.np-article__body h2 {
    font-family: var(--font-display);
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.2;
    margin: 3.5rem 0 1.25rem;
    letter-spacing: -0.015em;
}

.np-article__body h3 {
    font-family: var(--font-display);
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.3;
    margin: 2.5rem 0 1rem;
}

.np-article__body a {
    color: var(--accent);
    text-decoration: underline;
    text-underline-offset: 3px;
    text-decoration-thickness: 1px;
    transition: color .2s;
}
.np-article__body a:hover { color: var(--accent-dk); }

.np-article__body ul,
.np-article__body ol {
    padding-left: 1.5rem;
    margin-bottom: 2rem;
}
.np-article__body li {
    margin-bottom: 0.6rem;
    line-height: 1.7;
}
.np-article__body ul li::marker { color: var(--accent); }

.np-article__body strong {
    font-weight: 600;
    color: var(--ink);
}

.np-article__body em { font-style: italic; }

.np-article__body img {
    width: 100%;
    height: auto;
    margin: 3rem 0;
    display: block;
}

/* Pull quote / blockquote */
.np-article__body blockquote {
    position: relative;
    margin: 3.5rem 0;
    padding: 2.5rem 3rem 2.5rem 4rem;
    background: var(--surface);
    border-left: none;
    overflow: hidden;
}
.np-article__body blockquote::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--accent);
}
.np-article__body blockquote::after {
    content: '\201C';
    position: absolute;
    top: -10px;
    left: 20px;
    font-family: var(--font-display);
    font-size: 8rem;
    color: var(--accent);
    opacity: 0.12;
    line-height: 1;
    pointer-events: none;
}
.np-article__body blockquote p {
    font-family: var(--font-display);
    font-size: 1.35rem;
    font-style: italic;
    color: var(--ink);
    line-height: 1.55;
    font-weight: 400;
    margin-bottom: 0.5rem;
}
.np-article__body blockquote cite {
    font-size: 0.8rem;
    color: var(--ink-muted);
    font-family: var(--font-ui);
    font-style: normal;
    font-weight: 500;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

/* ============================================================
   IN-ARTICLE DIVIDER
   ============================================================ */
.np-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    margin: 3rem 0;
    color: var(--ink-faint);
    font-size: 20px;
    letter-spacing: 0.4em;
}
.np-divider::before,
.np-divider::after { content: ''; flex: 1; height: 1px; background: var(--rule); }

/* ============================================================
   TAGS
   ============================================================ */
.np-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--rule);
}
.np-tags__label {
    font-size: 11px;
    font-weight: 600;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-family: var(--font-ui);
    display: flex;
    align-items: center;
    gap: 8px;
    margin-right: 4px;
}
.np-tag {
    display: inline-block;
    background: var(--tag-bg);
    color: var(--ink-mid);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.04em;
    font-family: var(--font-ui);
    padding: 5px 12px;
    border-radius: 30px;
    text-decoration: none;
    transition: all .2s;
    border: 1px solid transparent;
}
.np-tag:hover { background: var(--accent-bg); color: var(--accent); border-color: #FFCDD4; }

/* ============================================================
   SHARE BAR
   ============================================================ */
.np-share-bar {
    margin-top: 2.5rem;
    padding: 1.5rem;
    background: var(--surface);
    border: 1px solid var(--rule);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}
.np-share-bar__label {
    font-size: 11px;
    font-weight: 600;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.14em;
    font-family: var(--font-ui);
}
.np-share-bar__buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.np-share-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    border: 1px solid var(--rule);
    background: var(--white);
    color: var(--ink-mid);
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
    border-radius: var(--radius-sm);
}
.np-share-btn:hover { background: var(--ink); color: var(--white); border-color: var(--ink); }
.np-share-btn svg { width: 14px; height: 14px; }

/* ============================================================
   AUTHOR BOX
   ============================================================ */
.np-author-box {
    margin-top: 3.5rem;
    padding: 2rem 2.5rem;
    border: 1px solid var(--rule);
    border-top: 3px solid var(--ink);
    background: var(--white);
    display: flex;
    gap: 24px;
    align-items: flex-start;
}

.np-author-box__avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: var(--ink);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 700;
    flex-shrink: 0;
}

.np-author-box__header {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 4px;
}
.np-author-box__label {
    font-size: 10px;
    font-weight: 600;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 0.16em;
    font-family: var(--font-ui);
}
.np-author-box__name {
    font-family: var(--font-display);
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.2;
    margin-bottom: 4px;
    margin-top: 4px;
}
.np-author-box__role {
    font-size: 11px;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    font-weight: 500;
    font-family: var(--font-ui);
    margin-bottom: 12px;
}
.np-author-box__bio {
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: var(--ink-mid);
    line-height: 1.7;
    font-weight: 300;
}

/* ============================================================
   POST NAV
   ============================================================ */
.np-post-nav {
    margin-top: 3.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: var(--rule);
    border: 1px solid var(--rule);
}
.np-post-nav__item {
    background: var(--white);
    padding: 1.5rem 1.75rem;
    text-decoration: none;
    transition: background .2s;
    display: block;
}
.np-post-nav__item:hover { background: var(--surface); }
.np-post-nav__item--prev { border-right: 1px solid var(--rule); }
.np-post-nav__direction {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 10px;
    font-weight: 600;
    color: var(--ink-muted);
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    margin-bottom: 8px;
}
.np-post-nav__direction svg { width: 14px; height: 14px; }
.np-post-nav__title {
    font-family: var(--font-display);
    font-size: 1rem;
    color: var(--ink);
    line-height: 1.35;
    font-weight: 700;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.np-post-nav__item--next { text-align: right; }

/* ============================================================
   SIDEBAR
   ============================================================ */
.np-sidebar {
    padding-top: 36px;
    position: sticky;
    top: 80px;
}

.np-sidebar__widget {
    margin-bottom: 2.5rem;
}
.np-sidebar__widget-title {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--ink);
    font-family: var(--font-ui);
    padding-bottom: 10px;
    border-bottom: 2px solid var(--ink);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.np-sidebar__widget-title span {
    display: inline-block;
    width: 6px;
    height: 6px;
    background: var(--accent);
    border-radius: 50%;
}

/* Related posts */
.np-related-card {
    display: flex;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid var(--rule);
    text-decoration: none;
    transition: opacity .2s;
}
.np-related-card:hover { opacity: 0.7; }
.np-related-card:last-child { border-bottom: none; }

.np-related-card__img {
    width: 72px;
    height: 52px;
    flex-shrink: 0;
    overflow: hidden;
    background: var(--surface);
}
.np-related-card__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.np-related-card__cat {
    font-size: 9px;
    font-weight: 600;
    color: var(--accent);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    margin-bottom: 4px;
}
.np-related-card__title {
    font-family: var(--font-display);
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Sidebar newsletter */
.np-sidebar__newsletter {
    background: var(--ink);
    color: var(--white);
    padding: 1.5rem;
}
.np-sidebar__nl-tag {
    font-size: 9px;
    font-weight: 600;
    color: var(--accent);
    letter-spacing: 0.18em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    margin-bottom: 8px;
}
.np-sidebar__nl-title {
    font-family: var(--font-display);
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 10px;
}
.np-sidebar__nl-text {
    font-size: 12px;
    color: #9999AA;
    font-family: var(--font-ui);
    line-height: 1.6;
    margin-bottom: 16px;
}
.np-sidebar__nl-input {
    width: 100%;
    padding: 10px 12px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: var(--white);
    font-size: 12px;
    font-family: var(--font-ui);
    margin-bottom: 8px;
    outline: none;
    transition: border-color .2s;
}
.np-sidebar__nl-input::placeholder { color: rgba(255,255,255,0.3); }
.np-sidebar__nl-input:focus { border-color: rgba(255,255,255,0.4); }
.np-sidebar__nl-btn {
    width: 100%;
    padding: 10px;
    background: var(--accent);
    color: var(--white);
    border: none;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    cursor: pointer;
    transition: background .2s;
}
.np-sidebar__nl-btn:hover { background: var(--accent-dk); }

/* ============================================================
   MORE STORIES (below article)
   ============================================================ */
.np-more-stories {
    background: var(--surface);
    border-top: 3px solid var(--ink);
    padding: 60px 24px;
}
.np-more-stories__inner {
    max-width: var(--content-w);
    margin: 0 auto;
}
.np-more-stories__header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 32px;
}
.np-more-stories__title {
    font-family: var(--font-display);
    font-size: 1.6rem;
    font-weight: 900;
    color: var(--ink);
    letter-spacing: -0.02em;
}
.np-more-stories__all {
    font-size: 11px;
    font-weight: 600;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    font-family: var(--font-ui);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: gap .2s;
}
.np-more-stories__all:hover { gap: 10px; }

.np-more-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 768px) {
    .np-more-grid { grid-template-columns: 1fr; }
}

.np-story-card {
    background: var(--white);
    text-decoration: none;
    display: block;
    border: 1px solid var(--rule);
    transition: box-shadow .3s, transform .3s;
}
.np-story-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.08);
}
.np-story-card__img {
    width: 100%;
    aspect-ratio: 16/10;
    overflow: hidden;
    background: var(--surface);
}
.np-story-card__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}
.np-story-card:hover .np-story-card__img img { transform: scale(1.04); }
.np-story-card__body { padding: 18px 20px 22px; }
.np-story-card__cat {
    font-size: 9px;
    font-weight: 600;
    color: var(--accent);
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    margin-bottom: 8px;
}
.np-story-card__title {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.35;
    margin-bottom: 10px;
}
.np-story-card__meta {
    font-size: 11px;
    color: var(--ink-muted);
    font-family: var(--font-ui);
}

/* ============================================================
   BACK BUTTON FOOTER
   ============================================================ */
.np-footer-action {
    background: var(--ink);
    padding: 40px 24px;
    text-align: center;
}
.np-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: transparent;
    color: var(--white);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 12px 28px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    font-family: var(--font-ui);
    text-decoration: none;
    transition: all .25s;
}
.np-back-btn:hover {
    background: var(--white);
    color: var(--ink);
    border-color: var(--white);
}
.np-back-btn svg { width: 16px; height: 16px; }
</style>

<div class="np-wrap">

    <!-- TOP BAR -->
    <div class="np-topbar">
        <span class="np-topbar__date"><?php echo date('l, F j, Y'); ?></span>
        <span class="np-topbar__edition">Costa Blanca Property Review</span>
        <div class="np-topbar__share">
            <a href="#" aria-label="Share on X">
                <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                X
            </a>
            <a href="#" aria-label="Share on LinkedIn">
                <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                LinkedIn
            </a>
        </div>
    </div>

    <!-- SECTION BREADCRUMB -->
    <div class="np-section-label">
        <div class="np-section-label__inner">
            <span class="np-section-label__tag"><?php echo esc_html($category); ?></span>
            <div class="np-section-label__trail">
                <a href="<?php echo home_url(); ?>">Home</a>
                <span>/</span>
                <a href="<?php echo home_url('/blog'); ?>">Journal</a>
                <span>/</span>
                <span><?php echo esc_html($category); ?></span>
            </div>
        </div>
    </div>

    <!-- HERO -->
    <header class="np-hero">
        <div class="np-hero__category"><?php echo esc_html($category); ?></div>
        <h1 class="np-hero__headline"><?php the_title(); ?></h1>
        <?php
        $excerpt = get_the_excerpt();
        if ($excerpt) : ?>
            <p class="np-hero__deck"><?php echo esc_html($excerpt); ?></p>
        <?php endif; ?>

        <!-- BYLINE -->
        <div class="np-byline">
            <div class="np-byline__author">
                <div class="np-byline__avatar"><?php echo esc_html(substr($author_name, 0, 1)); ?></div>
                <div class="np-byline__info">
                    <div class="np-byline__name">By <?php echo esc_html($author_name); ?></div>
                    <div class="np-byline__role"><?php echo esc_html($author_role); ?></div>
                </div>
            </div>
            <div class="np-byline__meta">
                <div class="np-byline__meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <?php echo get_the_date('F j, Y'); ?>
                </div>
                <div class="np-byline__meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Updated <?php echo get_the_modified_date('M j, Y'); ?>
                </div>
                <span class="np-byline__read-badge"><?php echo $read_time; ?> min read</span>
            </div>
        </div>
    </header>

    <!-- MAIN LAYOUT -->
    <div class="np-layout">

        <!-- PRIMARY COLUMN -->
        <main>
            <!-- Featured Image -->
            <div class="np-featured-img">
                <div class="np-featured-img__wrap">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>">
                </div>
                <?php if (get_post_meta($post_id, '_image_caption', true)) : ?>
                    <p class="np-featured-img__caption"><?php echo esc_html(get_post_meta($post_id, '_image_caption', true)); ?></p>
                <?php endif; ?>
            </div>

            <!-- Article Body -->
            <article class="np-article">
                <div class="np-article__body">
                    <?php the_content(); ?>
                </div>

                <!-- Tags -->
                <?php
                $tags = get_the_tags();
                if ($tags) : ?>
                    <div class="np-tags">
                        <span class="np-tags__label">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Topics
                        </span>
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="np-tag"><?php echo esc_html($tag->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Share Bar -->
                <div class="np-share-bar">
                    <span class="np-share-bar__label">Share this story</span>
                    <div class="np-share-bar__buttons">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" class="np-share-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            X / Twitter
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" class="np-share-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            LinkedIn
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="np-share-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            Facebook
                        </a>
                        <button onclick="navigator.clipboard.writeText('<?php echo get_permalink(); ?>').then(() => this.textContent = '✓ Copied')" class="np-share-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            Copy Link
                        </button>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="np-author-box">
                    <div class="np-author-box__avatar"><?php echo esc_html(substr($author_name, 0, 1)); ?></div>
                    <div>
                        <div class="np-author-box__label">Written by</div>
                        <h4 class="np-author-box__name"><?php echo esc_html($author_name); ?></h4>
                        <p class="np-author-box__role"><?php echo esc_html($author_role); ?></p>
                        <p class="np-author-box__bio">An expert voice in Costa Blanca real estate, providing deep market insights and localized knowledge for international investors and home buyers.</p>
                    </div>
                </div>

                <!-- Post Navigation -->
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                if ($prev_post || $next_post) : ?>
                    <nav class="np-post-nav">
                        <div>
                            <?php if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="np-post-nav__item np-post-nav__item--prev">
                                    <div class="np-post-nav__direction">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                        Previous Story
                                    </div>
                                    <div class="np-post-nav__title"><?php echo esc_html($prev_post->post_title); ?></div>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="np-post-nav__item np-post-nav__item--next">
                                    <div class="np-post-nav__direction" style="justify-content: flex-end;">
                                        Next Story
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </div>
                                    <div class="np-post-nav__title"><?php echo esc_html($next_post->post_title); ?></div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </nav>
                <?php endif; ?>
            </article>
        </main>

        <!-- SIDEBAR -->
        <aside class="np-sidebar">

            <!-- Newsletter widget -->
            <div class="np-sidebar__widget">
                <div class="np-sidebar__newsletter">
                    <div class="np-sidebar__nl-tag">Newsletter</div>
                    <div class="np-sidebar__nl-title">Stay informed on Costa Blanca property</div>
                    <p class="np-sidebar__nl-text">Weekly market analysis, investment insights, and featured listings — direct to your inbox.</p>
                    <input type="email" class="np-sidebar__nl-input" placeholder="Your email address">
                    <button class="np-sidebar__nl-btn">Subscribe to Journal →</button>
                </div>
            </div>

            <!-- Related posts widget -->
            <?php if (!empty($related_posts)) : ?>
                <div class="np-sidebar__widget">
                    <div class="np-sidebar__widget-title"><span></span> More in <?php echo esc_html($category); ?></div>
                    <?php foreach ($related_posts as $rp) :
                        $rp_img = has_post_thumbnail($rp->ID)
                            ? get_the_post_thumbnail_url($rp->ID, 'medium')
                            : 'https://images.pexels.com/photos/3944454/pexels-photo-3944454.jpeg?auto=compress&cs=tinysrgb&w=400';
                        $rp_cats = get_the_terms($rp->ID, 'blog_category');
                        $rp_cat  = !empty($rp_cats) ? $rp_cats[0]->name : $category;
                    ?>
                        <a href="<?php echo get_permalink($rp->ID); ?>" class="np-related-card">
                            <div class="np-related-card__img">
                                <img src="<?php echo esc_url($rp_img); ?>" alt="<?php echo esc_attr($rp->post_title); ?>">
                            </div>
                            <div>
                                <div class="np-related-card__cat"><?php echo esc_html($rp_cat); ?></div>
                                <div class="np-related-card__title"><?php echo esc_html($rp->post_title); ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- About the journal widget -->
            <div class="np-sidebar__widget">
                <div class="np-sidebar__widget-title"><span></span> About This Journal</div>
                <p style="font-size:13px; color:var(--ink-muted); line-height:1.7; font-family:var(--font-ui);">
                    The Costa Blanca Property Review is an independent editorial covering real estate trends, investment opportunities, and lifestyle insights across Spain's premier coastal region.
                </p>
            </div>

        </aside>
    </div>

    <!-- MORE STORIES (below article) -->
    <?php if (!empty($related_posts)) : ?>
        <section class="np-more-stories">
            <div class="np-more-stories__inner">
                <div class="np-more-stories__header">
                    <h2 class="np-more-stories__title">More From the Journal</h2>
                    <a href="<?php echo home_url('/blog'); ?>" class="np-more-stories__all">All Stories →</a>
                </div>
                <div class="np-more-grid">
                    <?php foreach ($related_posts as $rp) :
                        $rp_img = has_post_thumbnail($rp->ID)
                            ? get_the_post_thumbnail_url($rp->ID, 'medium_large')
                            : 'https://images.pexels.com/photos/3944454/pexels-photo-3944454.jpeg?auto=compress&cs=tinysrgb&w=600';
                        $rp_cats   = get_the_terms($rp->ID, 'blog_category');
                        $rp_cat    = !empty($rp_cats) ? $rp_cats[0]->name : $category;
                        $rp_words  = str_word_count(strip_tags($rp->post_content));
                        $rp_time   = ceil($rp_words / 200) ?: 1;
                    ?>
                        <a href="<?php echo get_permalink($rp->ID); ?>" class="np-story-card">
                            <div class="np-story-card__img">
                                <img src="<?php echo esc_url($rp_img); ?>" alt="<?php echo esc_attr($rp->post_title); ?>">
                            </div>
                            <div class="np-story-card__body">
                                <div class="np-story-card__cat"><?php echo esc_html($rp_cat); ?></div>
                                <div class="np-story-card__title"><?php echo esc_html($rp->post_title); ?></div>
                                <div class="np-story-card__meta"><?php echo get_the_date('M j, Y', $rp->ID); ?> &middot; <?php echo $rp_time; ?> min</div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- FOOTER ACTION -->
    <div class="np-footer-action">
        <a href="<?php echo home_url('/blog'); ?>" class="np-back-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to All Journal Entries
        </a>
    </div>

</div><!-- /.np-wrap -->