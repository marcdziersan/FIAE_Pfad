import unittest
from business_logic import gross, order_total_gross

class BusinessLogicTest(unittest.TestCase):
    def test_gross(self):
        self.assertEqual(gross(100), 119.0)

    def test_negative_net_raises(self):
        with self.assertRaises(ValueError):
            gross(-1)

    def test_order_total(self):
        self.assertEqual(order_total_gross([{"gross": 119.0}, {"gross": 59.5}]), 178.5)

if __name__ == "__main__":
    unittest.main()
