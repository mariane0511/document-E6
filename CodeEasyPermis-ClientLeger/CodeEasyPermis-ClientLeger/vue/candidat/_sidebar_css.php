<style>
    /* ===== SIDEBAR COMMUNE ===== */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
        display: flex;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    * { box-sizing: border-box; }

    .sidebar {
        width: 280px;
        min-width: 280px;
        background: white;
        padding: 30px 20px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }
    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 40px;
        padding: 0 10px;
    }
    .logo i { font-size: 32px; color: #6366f1; }
    .logo-text { font-size: 18px; font-weight: 600; color: #1f2937; }
    .logo-subtitle { font-size: 12px; color: #9ca3af; }
    .menu { flex: 1; }
    .menu-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 18px;
        margin-bottom: 8px;
        border-radius: 10px;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.3s;
        font-size: 15px;
    }
    .menu-item:hover { background: #f3f4f6; color: #6366f1; }
    .menu-item.active { background: #6366f1; color: white; }
    .menu-item i { width: 20px; font-size: 18px; }
    .user-section {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        border-top: 1px solid #e5e7eb;
        margin-top: 20px;
    }
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
        flex-shrink: 0;
    }
    .user-info h4 { font-size: 14px; color: #1f2937; margin-bottom: 2px; }
    .user-info p { font-size: 12px; color: #9ca3af; }
    .logout-btn { color: #ef4444; }
    .logout-btn:hover { background: #fee2e2; color: #ef4444; }

    /* ===== MAIN CONTENT ===== */
    .main-content {
        flex: 1;
        padding: 40px 50px;
        overflow-y: auto;
        min-height: 100vh;
    }

    /* ===== MODAL STYLES ===== */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal {
        background: white;
        border-radius: 16px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        text-align: center;
    }
    .modal-icon { font-size: 60px; margin-bottom: 20px; }
    .modal h2 { color: #1f2937; margin-bottom: 12px; }
    .modal p { color: #6b7280; margin-bottom: 24px; line-height: 1.6; }
    .modal-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s;
        margin: 0 6px;
    }
    .modal-btn-primary { background: #6366f1; color: white; }
    .modal-btn-primary:hover { background: #4f46e5; }
    .modal-btn-danger { background: #ef4444; color: white; }
    .modal-btn-danger:hover { background: #dc2626; }
    .modal-btn-secondary { background: #e5e7eb; color: #374151; }
    .modal-btn-secondary:hover { background: #d1d5db; }
</style>
