'use strict';
$(document).ready(function () {
  // ハートアイコンクリックで処理を発火
  $('.likes-icon').on('click', function () {
    const $btn = $(this);
    // product_idをfav-change.phpに投げ、お気に入りの状態を変更、それに応じて数字を変更する
    $.post({
      url: 'fav-change.php',
      data: {
        product_id: $btn.data('id'),
      },
      datatype: JSON,
    })
      .done(function (res) {
        $btn.children('p').text(res);
      })
      .fail(function (a, b, c) {
        console.log(c);
      });
    // ハートの状態管理するクラス、親のdivに.onがアクティブ状態
    // アニメーションの管理、子のi要素に.anim-heart/heart-close
    if ($btn.hasClass('on')) {
      // お気に入り解除の処理
      $btn.removeClass('on');
      $btn.children('i').attr('class', 'fa-regular fa-heart heart-close');
    } else {
      // お気に入り登録の処理
      $btn.addClass('on');
      $btn.children('i').attr('class', 'fa-solid fa-heart anim-heart');
    }
  });
});
