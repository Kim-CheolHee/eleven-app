<template>
    <div class="space-y-6 text-[17px] leading-8 text-black">
      <h1 class="text-2xl font-bold text-blue-700">
        ບົດທີ 7: ຂຽນສູດຄິດໄລຂອງຕົນເອງ (Custom Formula Writing)
      </h1>

      <p>
        ໃນ Excel ພວກເຮົາສາມາດຂຽນສູດຄິດໄລຂອງໂຕເອງໄດ້ໂດຍໃຊ້ສັນຍາລັກທາງຄະນິດສາດ. ຕາຕະລາງຂ້າງລຸ່ມນີ້ແມ່ນສັນຍາລັກທີ່ໃຊ້ໃນ Excel:
      </p>

      <table class="table-auto border border-gray-400 w-full text-center">
        <thead>
          <tr class="bg-gray-200">
            <th class="border border-gray-400 px-4 py-2">ສັນຍາລັກ</th>
            <th class="border border-gray-400 px-4 py-2">ຄວາມໝາຍ</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-gray-400 px-4 py-2">+</td>
            <td class="border border-gray-400 px-4 py-2">ບວກ (Addition)</td>
          </tr>
          <tr>
            <td class="border border-gray-400 px-4 py-2">-</td>
            <td class="border border-gray-400 px-4 py-2">ລົບ (Subtraction)</td>
          </tr>
          <tr>
            <td class="border border-gray-400 px-4 py-2">*</td>
            <td class="border border-gray-400 px-4 py-2">ຄູນ (Multiplication)</td>
          </tr>
          <tr>
            <td class="border border-gray-400 px-4 py-2">/</td>
            <td class="border border-gray-400 px-4 py-2">ຫານ (Division)</td>
          </tr>
          <tr>
            <td class="border border-gray-400 px-4 py-2">^</td>
            <td class="border border-gray-400 px-4 py-2">ກຳລັງ (Exponentiation)</td>
          </tr>
        </tbody>
      </table>

      <h2 class="text-xl font-semibold text-gray-700">🔹 ຂັ້ນຕອນຂຽນສູດເພື່ອຄຳນວນ:</h2>
      <ul class="list-decimal pl-6">
        <li>ເລືອກ Cell F2</li>
        <li>ພິມ =D2+E2 ເພື່ອບວກຈຳນວນຈາກ Cell D2 ແລະ E2</li>
        <li>ກົດ Enter ເພື່ອສະແດງຜົນລັບ</li>
      </ul>

      <img src="/images/study/84p_1.jpg" alt="Custom formula entry" class="rounded-xl border border-gray-300 shadow-md" />
      <p class="text-center text-sm text-gray-600">ຮູບ 7.3 ຂໍ້ມູນທີ່ໃຊ້ຂຽນສູດ</p>

      <img src="/images/study/84p_2.jpg" alt="Custom formula input" class="rounded-xl border border-gray-300 shadow-md" />
      <p class="text-center text-sm text-gray-600">ຮູບ 7.4 ການຂຽນສູດໃນ Cell F2</p>

      <h2 class="text-xl font-semibold text-gray-700">🔸 ການສຳເນົາສູດດ້ວຍ AutoFill:</h2>
      <ul class="list-decimal pl-6">
        <li>ເລືອກ Cell F2 ແລ້ວໃຊ້ Mouse ລາກໄປຍັງ Cell F6</li>
        <li>Excel ຈະສຳເນົາສູດແລະຄຳນວນແຕ່ລະແຖວໃຫ້ໂດຍອັດຕະໂນມັດ</li>
      </ul>

      <img src="/images/study/85p_1.jpg" alt="AutoFill Example" class="rounded-xl border border-gray-300 shadow-md" />
      <p class="text-center text-sm text-gray-600">ຮູບ 7.5 ການສຳເນົາສູດໃນ Excel</p>

      <img src="/images/study/85p_2.jpg" alt="AutoFill result" class="rounded-xl border border-gray-300 shadow-md" />
      <p class="text-center text-sm text-gray-600">ຮູບ 7.6 ຜົນລັບຈາກການສຳເນົາສູດ</p>

      <h2 class="text-xl font-semibold text-gray-700">🔍 ການໃຊ້ຟັງຊັນຄຳນວນ MIN:</h2>
      <ul class="list-decimal pl-6">
        <li>ເລືອກ Cell F6</li>
        <li>ພິມ =MIN(F2:F6) ແລ້ວ Enter</li>
      </ul>

      <img src="/images/study/86_1p_1.jpg" alt="MIN Function" class="rounded-xl border border-gray-300 shadow-md" />
      <p class="text-center text-sm text-gray-600">ຮູບ 7.7 ການນຳໃຊ້ MIN ໃນ Excel</p>

      <p class="text-blue-700 font-semibold">
        ✅ ຝຶກຂຽນສູດຄຳນວນຫຼາຍໆເພື່ອໃຊ້ໃນການຄຳນວນຈິງໄດ້ຢ່າງຖືກຕ້ອງ!
      </p>
    </div>
  </template>
