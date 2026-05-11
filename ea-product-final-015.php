<?php
/**
 * EA-PRODUCT-FINAL-015
 * -------------------------------------------------------
 * Task 1 — Update post_title to suggested_final for all Keep rows (644)
 * Task 2 — Set post_status to draft for all Delete rows (83)
 * Task 4 — Write variant postmeta for all Keep rows:
 *             _ea_variant_label  (e.g. "Matt Lamination 350gsm")
 *             _ea_product_group  (e.g. "Standard Business Cards")
 *             _ea_parent_sku     (e.g. "PS-001" or "" for parent)
 *
 * Invariants:
 *   - Slugs are NEVER changed
 *   - Media Library files and attachment records are NEVER touched
 *   - Ignore rows are skipped
 *   - Full report written to website-cleanup-dump/logs/ea-015-report.txt
 * -------------------------------------------------------
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$JSON_FILE   = __DIR__ . '/ea-audit-014-excel-data.json';
$REPORT_DIR  = __DIR__ . '/website-cleanup-dump/logs';
$REPORT_FILE = $REPORT_DIR . '/ea-015-report.txt';

/* ── Load data ── */
if ( ! file_exists( $JSON_FILE ) ) {
    echo "ERROR: JSON not found at {$JSON_FILE}\n";
    exit;
}
$rows = json_decode( file_get_contents( $JSON_FILE ), true );
if ( ! $rows ) {
    echo "ERROR: Failed to parse JSON\n";
    exit;
}
echo 'Loaded rows: ' . count( $rows ) . "\n";

/* ── Prepare report dir ── */
if ( ! is_dir( $REPORT_DIR ) ) {
    wp_mkdir_p( $REPORT_DIR );
}

/* ── Counters ── */
$t1_updated  = 0;
$t1_skipped  = 0;
$t1_err      = 0;
$t2_drafted  = 0;
$t2_skipped  = 0;
$t2_err      = 0;
$t4_written  = 0;
$t4_err      = 0;
$ignored     = 0;

$report_lines   = [];
$report_lines[] = '===== EA-PRODUCT-FINAL-015 EXECUTION REPORT =====';
$report_lines[] = 'Date: ' . date( 'Y-m-d H:i:s' );
$report_lines[] = 'Total rows: ' . count( $rows );
$report_lines[] = '';
$report_lines[] = '--- TASK 1: Product Name Updates (Keep) ---';

global $wpdb;

foreach ( $rows as $row ) {
    $sku          = trim( $row['sku']           ?? '' );
    $decision     = trim( $row['decision']      ?? '' );
    $suggested    = trim( $row['suggested_final'] ?? '' );
    $variant_lbl  = trim( $row['variant']       ?? '' );
    $group_name   = trim( $row['product_name']  ?? '' );
    $parent_sku   = trim( $row['parent_sku']    ?? '' );

    if ( empty( $sku ) ) continue;

    /* Look up product ID by SKU */
    $post_id = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta}
             WHERE meta_key = '_sku' AND meta_value = %s
             LIMIT 1",
            $sku
        )
    );

    if ( ! $post_id ) {
        $report_lines[] = "  WARN  SKU:{$sku} — not found in DB, skipping";
        continue;
    }

    $decision_lc = strtolower( $decision );

    /* ── IGNORE ── */
    if ( $decision_lc === 'ignore' ) {
        $ignored++;
        continue;
    }

    /* ── DELETE → TASK 2: set draft ── */
    if ( $decision_lc === 'delete' ) {
        $current_status = get_post_status( $post_id );
        if ( $current_status === 'draft' ) {
            $t2_skipped++;
            continue; // already draft
        }
        $result = wp_update_post( [
            'ID'          => $post_id,
            'post_status' => 'draft',
        ], true );

        if ( is_wp_error( $result ) ) {
            $t2_err++;
            $report_lines[] = "  ERROR  SKU:{$sku} ID:{$post_id} — draft failed: " . $result->get_error_message();
        } else {
            $t2_drafted++;
            // No title change for delete rows; log concisely in the delete section
        }
        continue; // skip to next row — no meta needed for deleted products
    }

    /* ── KEEP → TASK 1: update title ── */
    if ( $decision_lc === 'keep' ) {
        if ( empty( $suggested ) ) {
            $t1_skipped++;
            $report_lines[] = "  SKIP  SKU:{$sku} ID:{$post_id} — suggested_final is empty";
            continue;
        }

        $current_title = get_the_title( $post_id );
        if ( $current_title === $suggested ) {
            $t1_skipped++; // already correct
        } else {
            $result = wp_update_post( [
                'ID'         => $post_id,
                'post_title' => $suggested,
            ], true );

            if ( is_wp_error( $result ) ) {
                $t1_err++;
                $report_lines[] = "  ERROR  SKU:{$sku} ID:{$post_id} — title update failed: " . $result->get_error_message();
            } else {
                $t1_updated++;
                $report_lines[] = "  UPDATE  SKU:{$sku} ID:{$post_id} \"{$current_title}\" → \"{$suggested}\"";
            }
        }

        /* ── TASK 4: write variant meta ── */
        $meta_ok = true;

        $meta_ok = $meta_ok && ( false !== update_post_meta( $post_id, '_ea_variant_label', $variant_lbl ) );
        $meta_ok = $meta_ok && ( false !== update_post_meta( $post_id, '_ea_product_group',  $group_name  ) );
        $meta_ok = $meta_ok && ( false !== update_post_meta( $post_id, '_ea_parent_sku',     $parent_sku  ) );

        if ( $meta_ok ) {
            $t4_written++;
        } else {
            $t4_err++;
            $report_lines[] = "  META_ERR  SKU:{$sku} ID:{$post_id} — one or more meta writes failed";
        }

        continue;
    }

    /* Unknown decision value */
    $report_lines[] = "  UNKNOWN_DECISION  SKU:{$sku} decision:\"{$decision}\" — skipped";
}

/* ── Delete section in report ── */
$report_lines[] = '';
$report_lines[] = '--- TASK 2: Delete → Draft ---';
// Re-iterate just for report accuracy (counted above)
foreach ( $rows as $row ) {
    $sku      = trim( $row['sku']      ?? '' );
    $decision = strtolower( trim( $row['decision'] ?? '' ) );
    if ( $decision !== 'delete' ) continue;

    $post_id = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta}
             WHERE meta_key = '_sku' AND meta_value = %s
             LIMIT 1",
            $sku
        )
    );
    $status = $post_id ? get_post_status( $post_id ) : 'NOT_FOUND';
    $report_lines[] = "  SKU:{$sku} ID:{$post_id} status:{$status}";
}

/* ── Summary ── */
$report_lines[] = '';
$report_lines[] = '===== SUMMARY =====';
$report_lines[] = "Task 1 — Name Updated:   {$t1_updated}";
$report_lines[] = "Task 1 — Already OK:     {$t1_skipped}";
$report_lines[] = "Task 1 — Errors:         {$t1_err}";
$report_lines[] = "Task 2 — Set to Draft:   {$t2_drafted}";
$report_lines[] = "Task 2 — Already Draft:  {$t2_skipped}";
$report_lines[] = "Task 2 — Errors:         {$t2_err}";
$report_lines[] = "Task 4 — Meta Written:   {$t4_written}";
$report_lines[] = "Task 4 — Meta Errors:    {$t4_err}";
$report_lines[] = "Ignored:                 {$ignored}";
$report_lines[] = '';
$report_lines[] = '===== END EA-PRODUCT-FINAL-015 =====';

/* ── Output to console ── */
foreach ( $report_lines as $line ) {
    echo $line . "\n";
}

/* ── Write report file ── */
$written = file_put_contents( $REPORT_FILE, implode( "\n", $report_lines ) . "\n" );
if ( $written !== false ) {
    echo "\nReport written to: {$REPORT_FILE}\n";
} else {
    echo "\nWARN: Could not write report to {$REPORT_FILE}\n";
}
