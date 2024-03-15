document.addEventListener('DOMContentLoaded', function() {
    // toggle-btn要素を取得
    let btn = document.querySelector(".toggle-btn");
    // nav要素を取得
    let nav = document.querySelector("#navArea");

    // toggle-btn要素が存在するか確認し、存在する場合にのみイベントを設定する
    if (btn) {
        // クリックイベントリスナーを追加
        btn.addEventListener('click', function() {
            // nav要素にopenクラスを追加または削除
            nav.classList.toggle('open');
        });
        mask.addEventListener('click', function() {
            nav.classList.toggle('open');
        });
    }
});
