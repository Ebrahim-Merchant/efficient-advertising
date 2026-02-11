<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

<style>
.content-wrapper {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: var(--spacing-3xl);
}

.sidebar {
    position: sticky;
    top: 120px;
    height: fit-content;
}

.widget {
    background: var(--color-bg-white);
    padding: var(--spacing-xl);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    margin-bottom: var(--spacing-xl);
}

.widget:last-child {
    margin-bottom: 0;
}

.widget-title {
    font-size: var(--font-size-xl);
    font-weight: 600;
    margin-bottom: var(--spacing-lg);
    padding-bottom: var(--spacing-md);
    border-bottom: 2px solid var(--color-primary);
    position: relative;
}

.widget-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 2px;
    background: var(--color-secondary);
}

.widget ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.widget ul li {
    padding: var(--spacing-sm) 0;
    border-bottom: 1px solid var(--color-border-light);
}

.widget ul li:last-child {
    border-bottom: none;
}

.widget ul li a {
    color: var(--color-text-main);
    transition: all var(--transition-base);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.widget ul li a:hover {
    color: var(--color-primary);
    padding-left: var(--spacing-sm);
}

.widget ul li a::after {
    content: '→';
    opacity: 0;
    transition: opacity var(--transition-base);
}

.widget ul li a:hover::after {
    opacity: 1;
}

/* Search Widget */
.widget_search .search-form {
    display: flex;
    gap: var(--spacing-sm);
}

.widget_search input[type="search"] {
    flex: 1;
    padding: 0.75rem;
    border: 2px solid var(--color-border);
    border-radius: var(--radius-md);
}

.widget_search button {
    padding: 0.75rem 1.5rem;
    background: var(--color-primary);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition-base);
}

.widget_search button:hover {
    background: var(--color-primary-dark);
}

/* Recent Posts Widget */
.widget_recent_entries ul li {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xs);
}

.widget_recent_entries .post-date {
    font-size: var(--font-size-sm);
    color: var(--color-text-light);
}

/* Categories Widget */
.widget_categories select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-bg-white);
}

/* Tag Cloud Widget */
.tagcloud {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
}

.tagcloud a {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--color-bg-light);
    color: var(--color-text-main);
    border-radius: var(--radius-full);
    font-size: var(--font-size-sm) !important;
    transition: all var(--transition-base);
}

.tagcloud a:hover {
    background: var(--color-primary);
    color: var(--color-bg-white);
}

/* Ensure Sidebar Icons render correctly */
.widget i.fas, .widget i.fa-solid { font-family: "Font Awesome 6 Free" !important; font-weight: 900 !important; }
.widget i.far, .widget i.fa-regular { font-family: "Font Awesome 6 Free" !important; font-weight: 400 !important; }
.widget i.fab, .widget i.fa-brands { font-family: "Font Awesome 6 Brands" !important; font-weight: 400 !important; }

@media (max-width: 992px) {
    .content-wrapper {
        grid-template-columns: 1fr;
    }
    
    .sidebar {
        position: relative;
        top: 0;
    }
}
</style>
